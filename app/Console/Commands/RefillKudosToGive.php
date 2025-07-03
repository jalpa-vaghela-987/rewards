<?php

namespace App\Console\Commands;

use App\Jobs\ResetKudosToGive;
use App\Models\Company;
use App\Models\KudosRefill;
use Illuminate\Console\Command;

class RefillKudosToGive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refill:kudos_to_give {company=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'refills kudos to give, typically monthly';

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
        $company_id = $this->argument('company');
        if (! $company_id) {
            $companies = Company::all()->where('active', 1);
        } else {
            $company = Company::find((int) $company_id);
            if (! $company) {
                return 'no company found';
            }
            $companies = collect([$company]);
        }

        foreach ($companies as $c) {
            $kr = new KudosRefill;
            $kr->company()->associate($c);
            $kr->level_1_users = $c->users->where('level', '=', 1)->count();
            $kr->level_2_users = $c->users->where('level', '=', 2)->count();
            $kr->level_3_users = $c->users->where('level', '=', 3)->count();
            $kr->level_4_users = $c->users->where('level', '=', 4)->count();
            $kr->level_5_users = $c->users->where('level', '=', 5)->count();

            $kr->level_1_points_to_give = $c->level_1_points_to_give;
            $kr->level_2_points_to_give = $c->level_2_points_to_give;
            $kr->level_3_points_to_give = $c->level_3_points_to_give;
            $kr->level_4_points_to_give = $c->level_4_points_to_give;
            $kr->level_5_points_to_give = $c->level_5_points_to_give;
            $kr->kudos_refill_freq = $c->kudos_refill_freq;
            $kr->kudos_expiration_freq = min($c->kudos_expiration_freq, 30);
            $kr->save();

            foreach ($c->users as $u) {
                $job = (new ResetKudosToGive($u, $kr))->delay(now()->addSeconds(2));
                dispatch($job);
            }
        }
    }
}
