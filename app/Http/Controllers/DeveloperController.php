<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\ConversionRate;
use App\Models\KudosToGiveTransaction;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class DeveloperController extends Controller
{
    public function manageCompanySettings()
    {
        return view('developer.manage-company-settings');
    }

    public function conversionRates()
    {
        $conversionRates = ConversionRate::paginate(PER_PAGE);

        return view('developer.conversion-rates', compact('conversionRates'));
    }

    public function transactions()
    {
        $ts = Transaction::orderByDesc('created_at')->paginate(50);

        return view('developer.transactions', ['ts' => $ts]);
    }

    public function redemptions()
    {
        return view('developer.redemptions', [
            'ts' => Transaction::where('type', '=', 2)->latest()->paginate(50),
        ]);
    }

    public function show()
    {
        return view('developer.show');
    }

    public function transactions_kudos_to_give()
    {
        $ts = KudosToGiveTransaction::orderByDesc('created_at')->with(['user'])->paginate(50);

        return view('developer.transactions-kudos-to-give', ['ts' => $ts]);
    }

    public function company(Company $company)
    {
        return view('developer.company', ['company' => $company]);
    }

    public function companies()
    {
        return view('developer.companies');
    }

    public function activeCompanies()
    {
        $companies = Company::active()
            ->withCount(['users as active_users' => function (Builder $query) {
                $query->active();
            }])
            ->addSelect(['creator_name' => User::whereColumn('company_id', 'companies.id')
                ->select('name')
                ->orderBy('created_at')
                ->limit(1),
            ])
            ->addSelect(['creator_email' => User::whereColumn('company_id', 'companies.id')
                ->select('email')
                ->orderBy('created_at')
                ->limit(1),
            ])
            ->addSelect(['total_kudos' => User::whereColumn('company_id', 'companies.id')
                ->active()
                ->select(DB::raw('sum(users.points) as total_kudos')),
            ])
            ->addSelect(['total_kudos_to_give' => User::whereColumn('company_id', 'companies.id')
                ->active()
                ->select(DB::raw('sum(users.points_to_give) as total_kudos_to_give')),
            ])
            ->addSelect(['subscription_status' => Subscription::whereColumn('company_id', 'companies.id')
                ->select('stripe_status')
                ->orderBy('created_at', 'desc')
                ->limit(1),
            ])
            ->paginate(PER_PAGE);

        return view('developer.active-companies', compact('companies'));
    }

    public function billing(Company $company)
    {
        return view('dashboard.billing', ['company' => $company]);
    }

    public function activity(Company $company)
    {
        return view('dashboard.show', ['company' => $company]);
    }

    public function kudos()
    {
        return view('developer.kudos');
    }

    public function rewards()
    {
        return view('developer.rewards');
    }

    public function customizeTeams()
    {
        return view('developer.customize-teams');
    }

    public function invites()
    {
        return view('developer.invite-users');
    }

    public function sendKudosToGiveAway()
    {
        return view('developer.kudos-to-give-away');
    }

    public function toggleVerifiedCompany(Company $company)
    {
        $company->verified = ! $company->verified;
        $company->save();
        $message = 'Company status changed to '.($company->verified ? 'verified' : 'not verified');
        session()->flash('flash.banner', $message);

        return back();
    }

    public function companySetting()
    {
        return view('developer.company-setting');
    }
}
