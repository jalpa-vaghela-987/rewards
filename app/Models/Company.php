<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function Illuminate\Events\queueable;
use Illuminate\Support\Str;
use Laravel\Cashier\Billable;

class Company extends Model
{
    use HasFactory;
    use Billable;

    protected $appends = ['customized_name_of_kudos'];

    protected static function booted()
    {
        static::updated(
            queueable(function ($customer) {
                $customer->syncStripeCustomerDetails();
            })
        );
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function userInvitations()
    {
        return $this->hasMany(UserInvitation::class);
    }

    public function transactions()
    {
        return $this->hasManyThrough(Transaction::class, User::class);
    }

    public function redemptions()
    {
        return $this->hasManyThrough(Redemption::class, User::class);
    }

    public function teams()
    {
        return $this->hasManyThrough(Team::class, User::class);
    }

    public function rewards()
    {
        return $this->hasMany(Reward::class);
    }

    public function companyTransactions()
    {
        return $this->hasMany(CompanyTransaction::class);
    }

    public function whitelabel_company()
    {
        return $this->hasOne(WhitelabelCompany::class, 'company_id');
    }

    public function check_for_fraud()
    {
        $c = $this;

        $rs = Redemption::all()
            ->where('created_at', '>', now()->subDays(1))
            ->where('created_at', '<', now())
            ->where('is_custom', 0)
            ->where('tango_order_id', true);

        $total_spend = $rs->pluck('value')->sum();

        if ($c->verified) {
            if ($total_spend > 1000) {
                //return 'Partner rewards are not available at this time. Please try again soon.';
            }

            return false;
        }

        $cts = $c->CompanyTransactions
            ->where('active', 1)
            ->where('type', 1)
            ->where('transaction_sucessful', '!=', false)
            ->sortBy('transaction_sucessful');
        if (! $cts) {
            return 'Please contact an administrator user to refill the rewards balance to enable partner reward redemptions.';
        }
        $first_ct = $cts->first();
        $diff = now()->diffInHours($first_ct->transaction_sucessful);

        $min_allowed = 96;

        if ($diff < $min_allowed) {
            if (Auth::user()->role == 1) {
                return 'Due to strict compliance protocols from merchants to prevent fraudulent transactions, '.
                    appName().
                    ' does not allow gift card redemptions until '.
                    $min_allowed.
                    ' hours after funding has completed. Please try again soon or for immediate support, please contact support. We are sorry for any inconvienience.';
            }

            return 'Your company is not yet eligible for Partner Rewards. Please try again soon. For immediate support, please contact support.';
        }

        if ($total_spend > 1000) {
            return 'Partner rewards are not available at this time. Please try again soon.';
        }
    }

    public function productTour()
    {
        return $this->hasOne(Company::class, 'company_id');
    }

    public function grab_all_points($type = 'public')
    {
        $points = $this->users->flatten()->unique();

        if ($type == 'public') {
            $points = $points->pluck('recievers');
        } else {
            $points = $points->pluck('private_receiver_points');
        }

        return $points->flatten()->unique();
    }

    public function anyTeamHavingUsersMoreThan($usersCount)
    {
        $teams = $this->teams()
            ->withCount('users')
            ->get();

        foreach ($teams as $team) {
            if ($team->users_count > $usersCount) {
                return true;
            }
        }

        return false;
    }

    public function getCustomizedNameOfKudosAttribute($value)
    {
        return Str::ucfirst($value);
    }
}
