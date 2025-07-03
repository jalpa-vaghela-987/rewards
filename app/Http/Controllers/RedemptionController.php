<?php

namespace App\Http\Controllers;

use App\Jobs\SendRewardRedemptionRequest;
use App\Models\ConversionRate;
use App\Models\Redemption;
use App\Models\Reward;
use App\Models\Tango;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RedemptionController extends Controller
{
    public function redeem(Request $request)
    {
        /** @var Reward $reward */
        $reward = Reward::find($request->reward_id);

        if (! $reward && $reward->id) {
            return redirect()->route('wallet', ['currency' => auth()->user()->currency]);
        }

        $user = auth()->user();
        $conversionRate = 1.00;
        $tangoData = json_decode($reward->tango_data);
        $currency = $reward->currency;

        if (isset($tangoData, $tangoData->items)) {
            if ($tangoData->items[0]->currencyCode != 'USD') {
                if ($conversionRate = ConversionRate::reward($tangoData->items[0]->currencyCode)->base('USD')->first()) {
                    $conversionRate = $conversionRate->base_fx;
                }
                $currency = data_get($tangoData, 'items.0.currencyCode', $reward->currency);
            }
        }

        if ($reward->is_custom) {
            $min_kudos = round(max($reward->cost, 0));
            $max_kudos = round(max($reward->cost, 0));
        } else {
            $min_kudos = round(max($reward->min_value, 5) * (getCustomizeNumberOfKudos()) / $conversionRate);
            $max_kudos = round(min(max($reward->max_value, 0), 9999999) * (getCustomizeNumberOfKudos()) / $conversionRate);
        }
        //dd([$max_kudos,$min_kudos]);

        $request->validate([
                'amount'    => ['required', 'integer', "min:$min_kudos", "max:$max_kudos"],
                'reward_id' => ['required', Rule::exists('rewards', 'id'), 'integer'],
            ]);

        if ($reward->is_custom && $reward->enable_inventory_tracking && $reward->stock_amount < 1) {
            throw ValidationException::withMessages(['amount' => [
                'It looks like your company ran out of this type of reward. Please contact a company administrator to update the inventory to allow redemption or choose another reward.',
            ]]);
        }

        // if (auth()->user()->company->in_trial_mode) {
        //     return 'cannot redeem in free trial mode. Contact sales@perksweet.com.';
        // }

        //create base redemption
        $r = new Redemption;
        $r->is_auto_approved = false; // added this since I switched the default to be true
        $r->user()->associate(auth()->user());
        $r->reward()->associate($reward);
        $r->data = json_encode($reward);
        $r->value = $reward->is_custom ? 1 : $r->calculatedAmount($request->amount, $conversionRate);
        $r->cost = $request->amount;
        $r->is_custom = $reward->is_custom;
        $r->redemption_code = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'), 0, 12);
        $r->currency = $currency;
        $r->currency_rate = $conversionRate;
        $r->kudos_conversion_rate = getCustomizeNumberOfKudos();
        $r->usd_amount = $r->cost / getCustomizeNumberOfKudos();

        $calculatedAmount = $r->value;
        //dd($calculatedAmount);

        if ($user->points < $request->amount) {
            throw ValidationException::withMessages(['amount' => [
                'not enough '.getReplacedWordOfKudos(),
            ]]);
        }

        if ($reward->use_set_amount && $reward->is_custom) {
            if ($request->amount != $reward->cost) {
                throw ValidationException::withMessages(['amount' => [
                    'Redemption amount should be '.$reward->cost,
                ]]);
            }
        } else {
            if ($reward->max_value < (float) $calculatedAmount || $reward->min_value > $calculatedAmount) {
                $tmin = number_format($reward->min_value, 2);
                $tmax = number_format($reward->max_value, 2);
                throw ValidationException::withMessages(['amount' => [
                    'Redemption amount should be between '.$tmin.' and '.$tmax,
                ]]);
            }
        }

        if ($reward->tango_utid != null && $calculatedAmount > 0) {
            $request->validate([
                'amount' => ['required', 'integer', "min:$min_kudos", "max:$max_kudos"],
            ]);

            if (! auth()->user()->company->balance || auth()->user()->company->balance < $calculatedAmount / $conversionRate) {
                throw ValidationException::withMessages(['amount' => [
                    'Your company does not have enough reward partner credits to redeem this reward. Please contact a company administrator to add credit to '.appName().'. You have not been charged for this transaction.',
                ]]);
            }

            if ($this->check_for_fraud()) {
                return $this->check_for_fraud();
            }
        }

        //debit points from user account
        $user->points -= $request->amount;
        $user->save();
        $r->save();

        if ($reward->approval_needed) {
            dispatch(new SendRewardRedemptionRequest(auth()->user()->company_id, $r->id));

            session()->flash('flash.banner', 'Reward Redemption Request Sent!');

            return redirect()->route('purchased', ['redemption' => $r->id]);
        }

        /** @var Redemption $redemption */
        $redemption = $r->process();

        if (is_string($redemption)) {
            throw ValidationException::withMessages(['amount' => [
                $redemption,
            ]]);
        }

        session()->flash('flash.banner', 'Reward redeemed successfully!');

        return redirect()->route('purchased', ['redemption' => $r->id]);
    }

    public function check_for_fraud()
    {
        //returns error string if fraud detected
        //returns false if ok
        //return "here";

        return auth()->user()->company->check_for_fraud();
    }

    public function wallet()
    {
        if (auth()->user()->company->allow_tango_cards) {
            $this->refresh_tango2();
        }

        $rewards = Reward::active()
            ->when(request('currency', auth()->user()->currency), function ($q) {
                $q->whereJsonContains('tango_data->items', ['currencyCode' => request('currency', auth()->user()->currency)]);
            })
            ->isNotCustom()
            ->isEnabled()
            ->forCompany()
            ->get();

        $redeemedRewards = auth()->user()
            ->redemptions()
            ->latest()
            ->get();

        return view('rewards.wallet', compact('rewards', 'redeemedRewards'));
    }

    public function refresh_tango2()
    {
        Reward::active()
            ->where('tango_utid', '!=', null)
            ->where('company_id', null)
            ->update(['active' => 0]);

        foreach (Tango::all() as $t) {
            if (Reward::where('tango_utid', $t->tango_utid)->first()) {
                $reward = Reward::where('tango_utid', $t->tango_utid)->first();
            } else {
                $reward = new Reward;
            }

            $reward->title = $t->title;
            $reward->photo_path = $t->photo_path;
            $reward->description = $t->description;
            $reward->min_value = $t->min_value;
            $reward->brand_key = $t->brand_key;
            $reward->tango_utid = $t->tango_utid;
            $reward->tango_data = $t->tango_data;
            $reward->tango_currency = $t->tango_data == null ? 'USD' : json_decode($t->tango_data)->items[0]->currencyCode;
            $reward->tango_disclaimer = $t->tango_disclaimer;
            $reward->tango_terms = $t->tango_terms;
            $reward->tango_status = $t->tango_status;
            $reward->tango_redemption_instructions = $t->tango_redemption_instructions;
            $reward->active = $t->active;
            if ($t->disabled) {
                $reward->active = 0;
            }
            $reward->max_value = $t->max_value;
            $reward->tango_brand_requirements = $t->tango_brand_requirements;
            $reward->company()->associate(auth()->user()->company);
            $reward->save();
        }

        // $rs = Reward::all()->where('active',1);
        // dd($rs);
    }

    public function refresh_tango()
    {

        //depreciated as of 10/31/21

        Reward::active()->where('tango_utid', '!=', null)->update(['active' => 0]);

        $key = env('TANGO_API_KEY', '');
        $endpoint = env('TANGO_ENDPOINT', '');
        $platform = env('TANGO_PLATFORM', '');

        $response = Http::withBasicAuth($platform, $key)->get($endpoint.'catalogs', []);

        $body = ((json_decode($response->body())));
        if (! $body || ! isset($body->brands)) {
            return;
        }
        $brands = $body->brands;
        //dd($brands);
        foreach ($brands as $b1) {
            //$b1 = $brands[0];
            //echo "here";
            if ($b1->items[0]->valueType === 'VARIABLE_VALUE') {
                $reward = new Reward;
                $reward->title = $b1->items[0]->rewardName;
                $hold = '300w-326ppi'; //errored since the dash was there
                $reward->photo_path = $b1->imageUrls->$hold;
                $reward->description = $b1->shortDescription;
                $reward->min_value = max($b1->items[0]->minValue ?? 0, 10);
                $reward->brand_key = $b1->brandKey;
                $reward->tango_utid = $b1->items[0]->utid;
                $reward->tango_data = json_encode($b1);
                $reward->tango_currency = $b1->items[0]->currencyCode;
                $reward->tango_disclaimer = $b1->disclaimer ?? '';
                $reward->tango_terms = $b1->terms ?? '';
                $reward->tango_status = $b1->status;
                $reward->tango_redemption_instructions = $b1->items[0]->redemptionInstructions ?? '';
                if ($b1->status !== 'active') {
                    $reward->active = 0;
                }
                $reward->max_value = min($b1->items[0]->maxValue ?? 0, 100);
                $reward->tango_brand_requirements = json_encode($b1->brandRequirements);
                $reward->save();
            }
        }
    }

    public function purchased(Redemption $redemption)
    {
        if (
                Auth::user()->id == $redemption->user->id
            || (Auth::user()->company->id == $redemption->user->company->id && Auth::user()->role == 1)
            || Auth::user()->developer == 1
            ) {
            //ok
        } else {
            return 'unauthorized';
        }
        $redemptionUser = $redemption->user;

        if ($redemptionUser->id == auth()->id() || ($redemptionUser->company_id == auth()->user()->company_id && auth()->user()->role === 1)) {
            return view('rewards.purchased', ['reward' => json_decode($redemption->data), 'redemption' => $redemption]);
        }

        abort(404);
    }

    public function tango()
    {
        return false;

        $key = env('TANGO_API_KEY', '');
        $endpoint = env('TANGO_ENDPOINT', '');
        $platform = env('TANGO_PLATFORM', '');

        $response = Http::withBasicAuth($platform, $key)->post($endpoint.'orders', [
            'accountIdentifier'  => 'A58963409',
            'sendEmail'          => true,
            'customerIdentifier' => 'G31122875',
            'amount'             => 5,
            'notes'              => 'this is a test',
            'utid'               => 'U561621',
            'recipient'          => [
                'email'     => auth()->user()->email,
                'firstName' => substr(auth()->user()->name, 0, 90),
            ],
        ]);

        $body = (json_decode($response->body()));
        if (isset($body->status) && $body->status == 'COMPLETE') {
            $r = new Redemption;
            $hold2 = 'Redemption URL';
            $r->tango_link = $body->reward->credentials->$hold2;
            $r->tango_order_id = $body->referenceOrderID;
            $r->tango_customer_id = $body->customerIdentifier;
            $r->tango_account_id = $body->accountIdentifier;
            $r->tango_created_at = $body->createdAt;
            $r->tango_status = $body->status;
            $r->tango_amount = $body->amountCharged->value;
            $r->tango_utid = $body->utid;
            $r->tango_reward_name = $body->rewardName;
            $r->tango_notes = $body->notes;

            return $r;
        }

        return 'Transaction did not complete. No response from merchant, please try again or choose another gift card. We apologize for any inconvienience.';
    }

    public function catalog()
    {
        $key = env('TANGO_API_KEY', '');
        $endpoint = env('TANGO_ENDPOINT', '');
        $platform = env('TANGO_PLATFORM', '');

        $response = Http::withBasicAuth($platform, $key)->get($endpoint.'catalogs', []);

        $body = ((json_decode($response->body())));

        //dd($body);
        $brands = $body->brands;

        //dump($brands[0]->items[0]->valueType);
        foreach ($brands as $b1) {
            if ($b1->items[0]->valueType == 'VARIABLE_VALUE') {
                $r = new Reward;
                $r->title = $b1->items[0]->rewardName;
                $hold = '300w-326ppi'; //errored since the dash was there
                $r->photo_path = $b1->imageUrls->$hold;
                $r->description = $b1->shortDescription;
                $r->min_value = max($b1->items[0]->minValue ?? 0, 5);
                $r->brand_key = $b1->brandKey;
                $r->tango_utid = $b1->items[0]->utid;
                $r->save();
            }
        }
    }
}
