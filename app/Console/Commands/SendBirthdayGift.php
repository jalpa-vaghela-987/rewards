<?php

namespace App\Console\Commands;

use App\Jobs\SendSpecialDayGift;
use App\Models\Point;
use App\Models\User;
use Illuminate\Console\Command;

class SendBirthdayGift extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:birthday-gift {timezone}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will send Birthday gift to user';

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
            ->hasBirthday()
            ->timezone($timezone)
            ->chunk(50, function ($users) {
                foreach ($users as $user) {
                    dispatch((new SendSpecialDayGift($user, Point::TYPE_BIRTHDAY))->delay(now()->addSeconds(2)));
                }
            });
    }
}
