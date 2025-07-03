<?php

namespace App\Console\Commands;

use App\Jobs\SendSpecialDayReminder;
use App\Models\Point;
use App\Models\User;
use Illuminate\Console\Command;

class SendWorkAnniversaryReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:work-anniversary-reminder {timezone}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending work anniversary reminder to teammates before 1 day.';

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
        $timezone = $this->argument('timezone');

        User::active()
            ->timezone($timezone)
            ->hasWorkAnniversary(1)
            ->chunk(50, function ($users) {
                foreach ($users as $user) {
                    dispatch((new SendSpecialDayReminder($user, Point::TYPE_ANNIVERSARY))->delay(now()->addSeconds(2)));
                }
            });
    }
}
