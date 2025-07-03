<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\KudosToGiveTransaction;
use App\Models\Point;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserInvitation;
use App\Notifications\ReceivedMoreKudosToGive;
use App\Notifications\WelcomeToPerkSweet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserInvitationController extends Controller
{
    public function register($company, $hash)
    {
        if (\request()->has('redirect_to')) {
            session()->put('redirect_to', \request('redirect_to'));

            return redirect()->route('user.register', [
                'hash'    => $hash,
                'company' => $company,
            ]);
        }

        $c = Company::where('alias', '=', $company)->first();
        $ui = UserInvitation::where('hash', '=', $hash)->first();

        if ($ui && ($user = $ui->ghost_user)) {
            if ($user->signed_up_at) {
                session()->forget('redirect_to');

                return 'Invitation link has expired, please contact companies administrator to get a new invitation link.';
            }
        }

        if (! $c || ! $ui) {
            session()->forget('redirect_to');

            return 'Invitation link has expired, please contact companies administrator to get a new invitation link.';

            //            return 'invalid invitation, please request a new invitation.';
        }

        if ($ui->active == 0) {
            session()->forget('redirect_to');

            return 'Invitation link has expired, please contact companies administrator to get a new invitation link.';

            //            return 'inactive invitation';
        }
        if ($ui->created_at->diffInDays(now()) > INVITATION_EXPIRE_AFTER_DAYS) {
            // 2 months
            session()->forget('redirect_to');

            return 'This link has expired, please request a new invitation link from a company administrator.';
        }

        // checks to make sure it is ok to register the user;
        if ($c->id != $ui->company->id) {
            session()->forget('redirect_to');

            return 'invalid.';
        }

        $user = User::where('email', $ui->email)
            ->where('is_ghost', true)
            ->first();

        return view('user.register', ['ui' => $ui, 'user' => $user]);
    }

    public function store(Request $r, UserInvitation $ui)
    {
        $birthdate = null;

        $r->validate([
            'first_name'            => 'required|max:255',
            'last_name'             => 'required|max:255',
            'password'              => 'required|min:8',
            'password_confirmation' => 'required|same:password',
            'company_id'            => 'required|integer',
            'position'              => 'required|max:100',
            //            'birthday'              => ['nullable', 'date_format:Y-m-d', 'before:'.now()],
            'birthday_date'         => ['nullable'],
            'birthday_month'        => ['nullable'],
            'anniversary'           => [
                'nullable',
                'date_format:Y-m-d',
                'before:'.now(),
            ],
            'hash'                  => 'required',
            'email'                 => [
                'required',
                'max:255',
                \Illuminate\Validation\Rule::exists('users', 'email')->where(
                    'is_ghost',
                    true
                ),
            ],
        ]);

        $c = Company::find($r->company_id);
        $ui2 = UserInvitation::where('hash', '=', $r->hash)->first();
        $user = User::where('email', $r->email)->where('is_ghost', true)->first();

        $month = data_get($r, 'birthday_month');
        $date = data_get($r, 'birthday_date');

        if ($month > 0 && $date <= 0) {
            throw ValidationException::withMessages([
                'birthday_date' => [__('Please select birthday date.')],
            ]);
        }

        if ($date > 0 && $month <= 0) {
            throw ValidationException::withMessages([
                'birthday_month' => [__('Please select birthday month.')],
            ]);
        }

        if ($month > 0 && $date > 0) {
            $birthdate = "2001-$month-$date";
        }

        // checks to make sure it is ok to register the user;
        if ($ui2->id !== $ui->id) {
            return 'Invitation link has expired, please contact companies administrator to get a new invitation link.';
            //            return 'invalid';
        }
        if ($r->email !== $ui->email) {
            return 'Invitation link has expired, please contact companies administrator to get a new invitation link.';
            //            return 'invalid email.';
        }
        if ($c->id !== $ui->company->id) {
            return 'Invitation link has expired, please contact companies administrator to get a new invitation link.';
            //            return 'invalid.';
        }
        if ($ui->active === 0) {
            return 'Invitation link has expired, please contact companies administrator to get a new invitation link.';
            //            return 'inactive invitation';
        }
        if ($ui->created_at->diffInDays(now()) > INVITATION_EXPIRE_AFTER_DAYS) {
            // 2 months
            return 'This link has expired, please request a new invitation link from a company administrator.';
        }

        $fullName = collect([$r->first_name, $r->last_name])
            ->filter()
            ->implode(' ');

        $user->name = $fullName;
        $user->first_name = $r->first_name;
        $user->last_name = $r->last_name;
        $user->initials = get_initials($fullName);
        $user->password = bcrypt($r->password);
        $user->position = $r->position;
        $user->birthday = $birthdate;
        $user->anniversary = $r->anniversary;
        $user->is_ghost = false;
        $user->signed_up_at = now();
        $user->currency = $c->default_currency;
        $user->points = $c->default_kudos_amount;

        $user->markEmailAsVerified();

        //makes sure that the product tour is set up
        $user->setProductTour();

        $t = new KudosToGiveTransaction();
        $t->user()->associate($user);
        $t->type = 3;
        $t->link = '';
        $t->data = '';
        $t->amount = $user->get_level_points();
        $t->note = getReplacedWordOfKudos().' to give initial add for '.number_format($t->amount).' on '.Carbon::now()->format('m-d-Y');
        $t->expiration = Carbon::now()->addDays($c->kudos_expiration_freq);
        $t->amount_remaining = $t->amount;

        $user->points_to_give = $t->amount;

        if ($t->amount) {
            $t->save();
            $user->save();
            $user->notify(new WelcomeToPerkSweet($t));
            $user->notify(new ReceivedMoreKudosToGive($t));
        }

        $message = trans('point.special-day.welcome.message-body');

        $point = $this->givePoints($c->default_kudos_amount, $message, $user, $c);

        $this->createTransaction($point, $message, $user);

        auth()->login($user);

        if ($redirectTo = session()->get('redirect_to', null)) {
            session()->forget('redirect_to');

            return response()->redirectTo($redirectTo);
        }

        return redirect()->route('kudos.feed');
    }

    public function givePoints($amount, $message, $user, $company)
    {
        $point = new Point();
        $point->company_id = $company->id;
        $point->amount = $amount;
        $point->message = $message;
        $point->type = 'welcome';

        $point->reciever()->associate($user);
        $point->save();

        return $point;
    }

    public function createTransaction($point, $message, $user)
    {
        $transaction = new Transaction();
        $transaction->user()->associate($user);
        $transaction->point()->associate($point);
        $transaction->note = $message;
        $transaction->link = '/received/'.$point->id;
        $transaction->amount = $point->amount;
        $transaction->type = 1;
        $transaction->data = json_encode($point);
        $transaction->save();
    }
}
