<?php

namespace App\Http\Controllers;

use App\Models\ConversionRate;
use App\Models\Reward;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RewardController extends Controller
{
    public function view(User $user)
    {
        return view('rewards.view');
    }

    public function redeem(Reward $reward)
    {
        if (! $reward->active) {
            return back();
        }

//        if (Auth::user()->points < $reward->min_value) {
//            session()->flash('flash.banner', 'Redemption amount is below minimum');
//
//            return back();
//        }

        $conversionRate = 1.00;
        $tangoData = json_decode($reward->tango_data);
        $currency = 'USD';

        if (isset($tangoData, $tangoData->items)) {
            if ($tangoData->items[0]->currencyCode != 'USD') {
                if ($conversionRate = ConversionRate::reward($tangoData->items[0]->currencyCode)->base('USD')->first()) {
                    $conversionRate = $conversionRate->base_fx;
                }
                $currency = data_get($tangoData, 'items.0.currencyCode', 'USD');
            }
        }

        return view('rewards.redeem', compact('conversionRate', 'reward', 'currency'));
    }

    public function create()
    {
        return view('rewards.create');
    }

    public function company()
    {
        return view('rewards.company', ['currency' => auth()->user()->currency]);
    }

    public function company_reward(Reward $reward)
    {
        return view('rewards.create', ['reward' => $reward]);
    }

    public function companyStats()
    {
        abort_unless(\auth()->user()->role === 1, 403);

        return view('rewards.stats');
    }
}
