<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class PayingCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //this allows local to skip this!
        if ((env('DB_CONNECTION') === 'local' || env('APP_ENV') === 'local') && $request->user()) {
            return $next($request);
        }

        // this is the 30 days free
        if ($request->user() && $request->user()->company && ! $request->user()->company->subscribed('default')
             && $request->user()->company->created_at && $request->user()->company->created_at->addDays(30) > now()) {
            // This user is not a paying customer but is within trial window
            return $next($request);
        }

        if ($request->user() && $request->user()->company && ! $request->user()->company->subscribed('default')) {
            // This user is not a paying customer...
            if ($request->user()->role === 1 && $request->user()->company && $request->user()->company->id > 0 && $request->user()->level != 0) {
                //makes sure this is an admin user otherwise do not send them to billing...
                return redirect()->route('cashier.checkout.button', ['user_id'=>Auth::user()->id]);
            }
        }

        return $next($request);
    }
}
