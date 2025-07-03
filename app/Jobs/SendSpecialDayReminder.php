<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\TeamMemberHasSpecialDayReminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class SendSpecialDayReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $special_day;
    public $company;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $specialDay)
    {
        $this->user = $user;
        $this->special_day = $specialDay;
        $this->company = $user->company;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->sendNotificationToAllTeamMembers();
    }

    public function sendNotificationToAllTeamMembers()
    {
        $allTeamMembersId = DB::table('team_user')
            ->selectRaw('distinct(user_id)')
            ->where('user_id', '!=', $this->user->id)
            ->whereIn('team_id', $this->user->teams()->select('team_id'))
            ->pluck('user_id');

        User::active()->whereIn('id', $allTeamMembersId)
            ->chunk(15, function ($teamMembers) {
                foreach ($teamMembers as $teamMember) {
                    $teamMember->notify(
                        new TeamMemberHasSpecialDayReminder($this->user, trans('point.'.$this->special_day))
                    );
                }
            });
    }
}
