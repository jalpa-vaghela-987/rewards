<?php

namespace App\Http\Livewire;

use App\Models\Company;
use App\Models\KudosToGiveTransaction;
use App\Models\Tango;
use App\Models\Team;
use App\Models\User;
use App\Notifications\WelcomeToPerkSweet;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class CompanyUser extends Component
{
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $confirm_password;
    public $company_id;
    public $team_name = 'My First Team';
    public $team_id;
    public $position;
    public $birthday;
    public $birthday_month;
    public $birthday_date;
    public $anniversary;
    public $currency;

    public function mount($company_id)
    {
        $this->company_id = $company_id;

        $company = Company::findOrFail($company_id);

        if ($company) {
            $this->currency = $company->default_currency ?: 'USD';
        }

        if (
            $company_user = User::where('company_id', '=', $company_id)->first()
        ) {
            if (
                $team = Team::where('user_id', '=', $company_user->id)->first()
            ) {
                $this->team_id = $team->id;
            } else {
                $this->team_id = null;
            }
        }
    }

    public function render()
    {
        return view('livewire.company-user', [
            'currencies' => Tango::all()
                ->where('disable', 0)
                ->where('active', 1)
                ->pluck('currency')
                ->flatten()
                ->unique()
                ->sort()
                ->values()
                ->all(),
        ]);
    }

    public function createCompanyUser()
    {
        $birthdate = null;

        $data = $this->validate([
            'first_name' => 'required|max:26',
            'last_name' => 'required|max:26',
            'email' => 'required|email|unique:users|max:255',
            'position' => 'required|max:100',
            'birthday_date' => ['nullable'],
            'birthday_month' => ['nullable'],
            'anniversary' => [
                'nullable',
                'date_format:Y-m-d',
                'before:'.now(),
            ],
            'currency' => ['required', 'string'],
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'company_id' => 'required',
        ]);

        $month = data_get($data, 'birthday_month');
        $date = data_get($data, 'birthday_date');

        if ($month > 0 && $date <= 0) {
            return $this->addError(
                'birthday_date',
                'Please select birthday date.'
            );
        }

        if ($date > 0 && $month <= 0) {
            return $this->addError(
                'birthday_month',
                'Please select birthday month.'
            );
        }

        if ($month > 0 && $date > 0) {
            $birthdate = "2001-$month-$date";
        }

        $fullName = collect([
            data_get($data, 'first_name'),
            data_get($data, 'last_name'),
        ])
            ->filter()
            ->implode(' ');

        $user = new User();
        $user->first_name = data_get($data, 'first_name');
        $user->last_name = data_get($data, 'last_name');
        $user->initials = get_initials($fullName);
        $user->name = $fullName;
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->company_id = $data['company_id'];
        $user->position = $data['position'];
        $user->birthday = $birthdate;
        $user->anniversary = ! empty($data['anniversary'])
            ? $data['anniversary']
            : null;
        $user->currency = $data['currency'];
        $user->level = 3;
        $user->role = 1;
        $user->active = 1;

        $user->save();

        $c = Company::find((int) $data['company_id']);
        $t = new KudosToGiveTransaction();
        $t->user()->associate($user);
        $t->type = 3;
        $t->link = '';
        $t->data = '';
        $t->amount = $user->get_level_points();
        $t->note =
            getReplacedWordOfKudos().
            ' to give initial add for '.
            number_format($t->amount).
            ' on '.
            Carbon::now()->format('m-d-Y');
        $t->expiration = Carbon::now()->addDays($c->kudos_expiration_freq);
        $t->amount_remaining = $t->amount;
        if ($t->amount) {
            $t->save();
        }

        $user->points_to_give = $t->amount;
        $user->currency = $c->default_currency;

        Mail::to('sales@perksweet.com')->send(
            new \App\Mail\CompanyRegistered($c, $user)
        );

        $company_user_count = User::where(
            'company_id',
            '=',
            $data['company_id']
        )->count();

        if ($company_user_count > 1) {
            if ($this->team_id != null) {
                $teamToAssign = Team::find($this->team_id);
                $teamToAssign->users()->attach($user, ['role' => 'editor']);
            }
        } else {
            // if it is not here then it should not be running again...
            $team = new Team();
            $team->name = $this->team_name;
            $team->user_id = $user->id;
            $team->personal_team = 0;
            $result1 = $team->save();

            $teamToAssign = Team::find($team->id);

            $teamToAssign->users()->attach($user, ['role' => 'admin']);

            $user->sendEmailVerificationNotification();

            if ($result1) {
                $user->save();
                $user->notify(new WelcomeToPerkSweet($t));

                Auth::login($user);

                //makes sure that the product tour is set up
                $user->setProductTour();

                $this->emit('saved');

                $this->set_up_stripe($user);

                //return redirect()->to(url('/stripe/checkout/'.$user->id));
                return redirect()->route('welcome');
            }
        }

        //$this->emit('error');

        //return redirect()->to(url('/company/login/'.$user->id));
    }

    public function set_up_stripe($user)
    {
        //creates user and company on stripe!
        $u = $user;
        $c = $user->company;

        $options = [];
        $options['email'] = $u->email;
        $options['description'] =
            $u->name.
            ' signed up for '.
            appName().
            ' for '.
            $c->name.
            ' on '.
            now();
        $options['name'] = $c->name;
        $metadata = [];
        $metadata['company_id'] = $c->id;
        $metadata['user_id'] = $u->id;
        $metadata['timestamp'] = now();
        $metadata['is_trial'] = 0;
        $options['metadata'] = $metadata;

        $stripeCustomer = $c->createAsStripeCustomer($options);
    }
}
