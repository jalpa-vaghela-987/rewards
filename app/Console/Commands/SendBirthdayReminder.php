<?php

namespace App\Console\Commands;

use App\Jobs\SendSpecialDayReminder;
use App\Models\Point;
use App\Models\User;
use Illuminate\Console\Command;

class SendBirthdayReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:birthday-reminder {timezone}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending birthday reminder to teammates before 1 day.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $timezone = $this->argument('timezone');

        User::active()
            ->hasBirthday(1)
            ->timezone($timezone)
            ->chunk(50, function ($users) {
                foreach ($users as $user) {
                    dispatch((new SendSpecialDayReminder($user, Point::TYPE_BIRTHDAY))->delay(now()->addSeconds(2)));
                }
            });
    }
}
