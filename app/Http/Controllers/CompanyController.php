<?php

namespace App\Http\Controllers;

use App\Jobs\KudosMonthlyPointsToGive;
use App\Models\Company;
use App\Models\CompanyInvitation;
use App\Models\User;
use App\Models\UserInvitation;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\RegisterResponse;

class CompanyController extends Controller
{
    protected $guard;

    /**
     * Create a new controller instance.
     *
     * @param \Illuminate\Contracts\Auth\StatefulGuard $guard
     * @return void
     */
    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    //
    public function show()
    {
        return view('company.show');
    }

    public function refillKudos()
    {
        $user_arr = User::all();
        foreach ($user_arr as $user) {
            ini_set('max_execution_time', '300');
            $job = new KudosMonthlyPointsToGive($user);
            $job->delay(Carbon::now()->addMinutes(5));
            dispatch($job);
        }
    }

    public function create_form()
    {
        Auth::logout();

        return view('company.create');
    }

    public function create_user($alias)
    {
        if ($alias != null) {
            $company = Company::where('alias', '=', $alias)->firstOrFail();
            $user = User::where('company_id', $company->id)->count();
            if ($company) {
                $company_id = $company->id;
                $data['company_id'] = $company_id;

                return view('company.create_user', compact('data', 'company', 'user'));
            }

            return redirect()->to(url('/login'));
        }

        return redirect()->to(url('/login'));
    }

    public function accept($invitation)
    {
        $invite = CompanyInvitation::where('id', '=', $invitation)->first();

        if ($invite !== null) {
            $company_id = $invite->company_id;
            $data['company_id'] = $company_id;

            //$invite->delete();

            return view('company.create_user', compact('data'));
        }

        return redirect()->to(url('/login'));
    }

    public function login($userId)
    {
        $user = User::where('id', '=', $userId)->first();
        $this->guard->login($user);

        return app(RegisterResponse::class);
    }

    public function manage_users()
    {
        return view('company.manage-users');
    }

    public function kudos()
    {
    }

    public function userStats()
    {
        abort_unless(\auth()->user()->role === 1, 403);

        return view('company.user-stats');
    }

    public function manageInvites()
    {
        abort_unless(\auth()->user()->role === 1, 403);

        return view('company.invites');
    }

    public function editInvitation(UserInvitation $invitation)
    {
        abort_unless($invitation && $invitation->ghost_user && ! $invitation->ghost_user->signed_up_at, 404);

        return view('company.edit-invites', ['invitation' => $invitation]);
    }

    public function updateInvitation()
    {
        // TODO: put logic here to update invitation
    }

    public function bulk_invite()
    {
        return view('company.bulk-user-invites');
    }
}
