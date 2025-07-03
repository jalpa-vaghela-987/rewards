<?php

namespace App\Console\Commands;

use App\Models\KudosToGiveTransaction;
use Carbon\Carbon;
use Illuminate\Console\Command;

//use Symfony\Component\Console\Output\ConsoleOutput;

class ExpireKudosToGive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expire:kudo_to_give';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'expires kudos to give, typically 1 months';

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
        //$now->subDays(80); // TESTING ONLY
        $ts = KudosToGiveTransaction::all()
            ->where('type', '=', 1)
            ->where('expiration', '<', $now)
            ->where('expired', '=', 0);

        foreach ($ts as $t) {
            $t->expired = 1;
            $t->save();

            $u = $t->user;
            $u->points_to_give -= $t->amount_remaining;
            if ($u->points_to_give < 0) {
                $u->points_to_give = 0;
            }
            $u->save();

            $t2 = new KudosToGiveTransaction;
            $t2->user()->associate($t->user);
            $t2->amount = -1 * $t->amount_remaining;
            $t2->type = 2;
            $t2->note = getReplacedWordOfKudos().' to give of '.number_format($t->amount_remaining).' expired on '.Carbon::now()->format('m-d-Y');
            $t2->amount_remaining = 0;
            if ($t->amount_remaining > 0) {
                $t2->save();
            }
        }

        // $output = new ConsoleOutput();
        // $output->writeln($krs->first()->id);
    }
}
