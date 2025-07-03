<?php

namespace App\Providers;

use App\Models\Team;
use App\Policies\TeamPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Team::class => TeamPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('view_team', function ($user) {
            $return = false;
            if ($user->role === 0 && $user->level === 0) {
                $return = true;
            }

            return $return;
        });

        Gate::define('view_reward', function ($user) {
            $return = false;
            if ($user->role === 0 && $user->company_id > 0) {
                $return = true;
            }

            return $return;
        });

        Gate::define('view_company', function ($user) {
            $return = false;
            if ($user->role === 0 && $user->company_id > 0 && $user->level === 0) {
                $return = true;
            }

            return $return;
        });

        Gate::define('add_CompanyTeamMember', function ($user) {
            $return = false;
            if ($user->role === 0 && $user->company_id > 0 && $user->level === 0) {
                $return = true;
            }

            return $return;
        });

        Gate::define('add_adminUser', function ($user) {
            $return = false;
            if ($user->role === 0 && $user->company_id == 0 && $user->level === 0) {
                $return = true;
            }

            return $return;
        });

        Gate::define('view_kudos', function ($user) {
            $return = false;
            if ($user->role === 0 && $user->company_id > 0 && $user->level === 0) {
                $return = true;
            }

            return $return;
        });

        Gate::define('refil_kudos', function ($user) {
            $return = false;
            if ($user->role === 0 && $user->company_id > 0 && $user->level === 0) {
                $return = true;
            }

            return $return;
        });

        Gate::define('access_admin_controls', function ($user) {
            $return = false;
            if ($user && $user->role === 1 && $user->company_id > 0 && $user->level != 0) {
                $return = true;
            }

            return $return;
        });

        Gate::define('is_developer_user', function ($user) {
            if ($user) {
                return $user->developer === 1 && $user->company_id > 0 && $user->level != 0;
            }

            return false;
        });

        //
    }
}
