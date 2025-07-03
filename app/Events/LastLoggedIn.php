<?php

namespace App\Events;

use App\Mail\TestAmazonSes;
use Auth;
use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class LastLoggedIn
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        //echo "here";
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        //return;
        //return new PrivateChannel('channel-name');
    }

    public function handle()
    {
        //Mail::to('nick@perksweet.com')->send(new TestAmazonSes('This is a test email'));
        Auth::user()->last_login = Carbon::now()->toDateTimeString();
        Auth::user()->save();

        //makes sure that the product tour is set up
        auth()->user()->setProductTour();

        // sends usage to stripe

        if (env('APP_ENV') != 'local') {
            $user = Auth::user();
            $company = $user->company;
            $c_users = $company->users->where('active', 1)->count();
            if ($c_users && $company->subscription('default')) {
                $company->subscription('default')->reportUsage($c_users);
            }
        }
    }
}
