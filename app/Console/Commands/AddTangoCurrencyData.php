<?php

namespace App\Console\Commands;

use App\Models\Reward;
use Illuminate\Console\Command;

class AddTangoCurrencyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:tango-currency';

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
            $tangoData = json_decode($reward->tango_data);
            if (isset($tangoData, $tangoData->items)) {
                $reward->tango_currency = data_get($tangoData, 'items.0.currencyCode');
                $reward->save();
            } else {
                $reward->tango_currency = $reward->currency;
                $reward->save();
            }
        }
    }
}
