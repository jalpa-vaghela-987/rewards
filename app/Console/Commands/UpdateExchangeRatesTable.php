<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Models\ConversionRate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpdateExchangeRatesTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange-rates:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update exchange rates table';

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
        $key = env('TANGO_API_KEY');
        $endpoint = env('TANGO_ENDPOINT');
        $platform = env('TANGO_PLATFORM');

        $response = Http::withBasicAuth($platform, $key)->get(
            $endpoint.'exchangerates',
            []
        );

        $body = ((json_decode($response->body())));
        if (! $body || ! isset($body->exchangeRates)) {
            exit;
        }
        $exchangeRates = $body->exchangeRates;

        foreach ($exchangeRates as $exchangeRate) {
            ConversionRate::updateOrCreate(
                ['reward_currency' => data_get($exchangeRate, 'rewardCurrency'), 'base_currency' => data_get($exchangeRate, 'baseCurrency')],
                ['base_fx' => data_get($exchangeRate, 'baseFx')]
            );
        }
        //echo "here1";

        foreach (Company::all()->where('default_currency', '<>', 'USD')->where('auto_update_currency', 1) as $c) {
            $conversionRate = 1.00;
            $currency = 'USD';

            if ($c->default_currency !== 'USD') {
                if ($conversionRate = ConversionRate::reward($c->default_currency)->base('USD')->first()) {
                    $conversionRate = $conversionRate->base_fx;
                }
            }
            $c->customized_number_of_kudos = $conversionRate;
            //echo $conversionRate;
            $c->save();
        }

        return Command::SUCCESS;
    }
}
