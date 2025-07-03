<?php

namespace App\Console\Commands;

use App\Jobs\KudosMonthlyPointsToGive;
use App\Jobs\ResetKudosToGive;
use App\Models\User;
use Illuminate\Console\Command;

class RefillKudos extends Command
{
    // DO NOT USE- THIS IS Depreciated!

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refill:kudos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monthly refill kudos to give';

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
        $user_arr = User::active()->all();
        foreach ($user_arr as $user) {
            ini_set('max_execution_time', '300');
            //$job = new KudosMonthlyPointsToGive($user);
            //$job->delay(Carbon::now()->addMinutes(5));
            //$job = new ResetKudosToGive($user);
            //dispatch($job);
        }
    }
}
