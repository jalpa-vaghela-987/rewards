<?php

namespace App\Console\Commands;

use App\Jobs\KudosToGiveAboutToExpire as KJ;
use App\Models\KudosToGiveTransaction;
use Carbon\Carbon;
use Illuminate\Console\Command;

class KudosToGiveAboutToExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expire:kudos_to_give_expire_in_1_week';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends users a notification that kudos they can give will expire in 1 week if not sent';

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
        $now = Carbon::now();
        //$now->addDays(28); // TESTING ONLY
        $ts = KudosToGiveTransaction::all()
            ->where('type', '=', 1)
            ->where('expiration', '>', $now)
            ->where('expiration', '<=', $now->addWeeks(1))
            ->where('expired', '=', 0)
            ->where('amount_remaining', '>', 0);

        foreach ($ts as $t) {
            $job = (new KJ($t))->delay(now()->addSeconds(3));
            dispatch($job);
        }
    }
}
