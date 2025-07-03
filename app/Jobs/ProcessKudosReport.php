<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\KudosEmailReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessKudosReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $company = $this->user->company;

        if (! $company->grab_all_points()) {
            return 'no kudos';
        }
        if ($company->grab_all_points()->count() < 1) {
            return 'no kudos';
        }

        $last_wednesday = now()->previous('Wednesday');
        $last_wednesday->hour = 16;
        //dd($last_wednesday->format('g:i A \o\n F jS, Y'));

        $ps = $company->grab_all_points()->unique()
            ->where('created_at', '>', $last_wednesday)
            ->where('created_at', '<', now())
            ->sortByDesc('created_at');

        //send kudos report to user only, if there are kudos in current week.
        if (count($ps)) {
            $this->user->notify(new KudosEmailReport($ps));
        }
    }
}
