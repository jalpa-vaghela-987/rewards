<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\UpcomingSpecialDayReport;
use Illuminate\Console\Command;

class UpcomingSpecialDayReminderReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remind:upcoming-special-days-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will send report of upcoming birthday and anniversaries.';

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
        User::active()
            ->emailOptIn()
            ->chunk(50, function ($users) {
                /** @var User $user */
                foreach ($users as $user) {
                    $user->notify(new UpcomingSpecialDayReport());
                }
            });
    }
}
