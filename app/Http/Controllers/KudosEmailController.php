<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\KudosEmailReport;
use Auth;

class KudosEmailController extends Controller
{
    public function test_report()
    {
        $this->generate_kudos(Auth::user());
    }

    public function generate_kudos(User $user)
    {
        return;
        // this is depreciated
        $company = $user->company;
        if (! $company->grab_all_points()) {
            return 'no kudos';
        }
        $last_wednesday = now()->previous('Wednesday');
        $last_wednesday->hour = 15;
        //dd($last_wednesday);

//        dd($last_wednesday->format('g:i A \o\n F jS, Y'));

        $ps = $company->grab_all_points()->unique()
        ->where('created_at', '>', $last_wednesday)
        ->where('created_at', '<', now())
        ->sortByDesc('created_at');

        $n = new KudosEmailReport($ps);
        $user->notify($n);
    }
}
