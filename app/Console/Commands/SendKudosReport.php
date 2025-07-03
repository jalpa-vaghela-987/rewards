<?php

namespace App\Console\Commands;

use App\Jobs\ProcessKudosReport;
use App\Models\User;
use Illuminate\Console\Command;

class SendKudosReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:kudos_report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sends out the weekly email report';

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
                foreach ($users as $user) {
                    dispatch(new ProcessKudosReport($user));
                }
            });
    }
}
