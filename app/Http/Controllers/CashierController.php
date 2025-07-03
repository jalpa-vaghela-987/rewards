<?php

namespace App\Http\Controllers;

use App\Models\CompanyTransaction;
use App\Models\User;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function create_stripe_checkout($user_id)
    {
        //allows local dev to skip payment process...
        if (env('DB_CONNECTION') === 'local') {
            return redirect()->route('kudos.feed');
        }

        $u = User::find($user_id);
        if ($u->id !== auth()->user()->id) {
            return 'invalid user';
        }

        $checkout = auth()->user()->company
        ->newSubscription('default', [])
        ->meteredPrice(env('STRIPE_PRICE_ID'))
        ->trialDays(min(35, max(0, 31 - auth()->user()->company->created_at->diffInDays(now()))))
        ->allowPromotionCodes()
        ->checkout([
                'success_url' => route('billing'),
                'cancel_url' => route('kudos.feed'),
            ]);

        return view('stripe.checkout', [
            'checkout' => $checkout,
        ]);
    }

    public function billing_portal(Request $request)
    {
        return $request->user()->company->redirectToBillingPortal(route('billing'));
    }

    public function verify_refill($hash)
    {
        $ct = CompanyTransaction::where('hash', $hash)->where('active', 0)->first();

        /** @var CompanyTransaction $ct */
        if (! $ct || ! $ct->id || $ct->hash !== $hash) {
            return 'Invalid Key. Please contact support';
        }

        if ($ct->user->id !== auth()->user()->id) {
            return 'Invalid User. Please contact support.';
        }

        if ($ct->user->developer !== 1 && $ct->company_id !== auth()->user()->company_id) {
            return 'Invalid Company. Please contact support';
        }

        if ($ct->amount <= 0 || $ct->amount > 10000) {
            return 'Transaction Amount Invalid or Denied. Please contact support.';
        }

        if ($ct->active) {
            return 'Transaction has already been marked as completed. Please check company balance and contact support if required.';
        }

        if ($ct->type !== 1) {
            return 'Wrong Transaction Type. Please contact support';
        }

        $c = $ct->company;
        $c->balance = $c->balance + $ct->amount;
        $c->cumulative_balance += $ct->amount;
        $c->last_added_balance = $ct->amount;
        $c->balance_updated = now();
        $c->save();
        $ct->active = 1;
        $ct->transaction_sucessful = now();
        $ct->save();

        session()->flash('flash.banner', 'Transaction Successful!');

        if ($ct->fundedByDeveloper()) {
            return redirect()->route('developer.billing', ['company' => $ct->company_id]);
        }

        return redirect('billing');
    }

    //////////////////for testing only

    public function testing()
    {
        return 'depreciated 1';
        $c = auth()->user()->company;
        $u = auth()->user();

        $options = [];
        $options['email'] = $u->email;
        $options['description'] = $u->name.' signed up for '.appName().' for '.$c->name.' on '.now();
        $options['name'] = $c->name;
        $metadata = [];
        $metadata['company_id'] = $c->id;
        $metadata['user_id'] = $u->id;
        $metadata['timestamp'] = now();
        $metadata['is_trial'] = 0;
        $options['metadata'] = $metadata;

        return $c->createAsStripeCustomer($options);
    }

    public function checkout()
    {
        return 'depreciated 2';
        $checkout = auth()->user()->company
        ->newSubscription('default', 'price_1J4WrtCioUdMUSQtQ5nK9pZb')
        ->checkout([
                'success_url' => route('manage.company'),
                'cancel_url' => route('manage.company'),
            ]);
        //$j_checkout = json_decode($checkout);
        //return $checkout
        $name1 = 'session';
//        dd($checkout);

        // return view('stripe.checkout', [
        //     'checkout' => $checkout,
        // ]);
    }

    public function create_stripe_customer()
    {
        return 'depreciated 3';
        $c = auth()->user()->company;
        $u = auth()->user();

        $options = [];
        $options['email'] = $u->email;
        $options['description'] = $u->name.' signed up for '.appName().' for '.$c->name.' on '.now();
        $options['name'] = $c->name;
        $metadata = [];
        $metadata['company_id'] = $c->id;
        $metadata['user_id'] = $u->id;
        $metadata['timestamp'] = now();
        $metadata['is_trial'] = 0;
        $options['metadata'] = $metadata;

        return $c->createAsStripeCustomer($options);
    }
}
