<?php

namespace App\Console\Commands;

use App\Models\Reward;
use Illuminate\Console\Command;

class AddInventoryRedeemedData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:inventory-redeemed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $rewards = Reward::all();
        foreach ($rewards as $reward) {
            $reward->inventory_redeemed = $reward->RewardCount ? $reward->RewardCount : '0';
            $reward->save();
        }
    }
}
