<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\FriendlyReminderToSendKudos;
use Illuminate\Console\Command;

class FriendlySendKudosReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'friendly-reminder:send-kudos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will send reminder to users who haven\'t send kudos in past 30 days.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $reminderDay = 30;

        $userCursor = User::active()
            ->hasJoinedSystem($reminderDay)
            ->whereDoesntHave('notifications', function ($q) use ($reminderDay) {
                $q->where('type', FriendlyReminderToSendKudos::class)
                    ->where('created_at', '>=', $reminderDay);
            })
            ->cusrsor();

        foreach ($userCursor as $user) {
            $user->notify(new FriendlyReminderToSendKudos($user));
        }
    }
}
