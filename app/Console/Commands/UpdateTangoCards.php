<?php

namespace App\Console\Commands;

use App\Models\Reward;
use App\Models\Tango;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpdateTangoCards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tango:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'refreshes TangoCards from the TangoCard API';

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

        // the below is copied from TangoController
        $response = Http::withBasicAuth($platform, $key)->get($endpoint.'catalogs', []);

        $body = ((json_decode($response->body())));
        if (! $body || ! isset($body->brands)) {
            return;
        }

        $brands = $body->brands;

        foreach ($brands as $b1) {
            if ($b1->items[0]->valueType === 'VARIABLE_VALUE') {
                if (Tango::where('tango_utid', $b1->items[0]->utid)->first()) {
                    $reward = Tango::where('tango_utid', $b1->items[0]->utid)->first();
                } else {
                    $reward = new Tango;
                    $reward->disabled = 0;
                }

                $reward->title = $b1->items[0]->rewardName;
                $hold = '300w-326ppi'; //errored since the dash was there
                $reward->photo_path = $b1->imageUrls->$hold;
                $reward->description = $b1->shortDescription;
                $reward->min_value = max($b1->items[0]->minValue ?? 0, 1);
                $reward->brand_key = $b1->brandKey;
                $reward->tango_utid = $b1->items[0]->utid;
                $reward->tango_data = json_encode($b1);
                $reward->tango_disclaimer = $b1->disclaimer ?? '';
                $reward->tango_terms = $b1->terms ?? '';
                $reward->tango_status = $b1->status;
                $reward->tango_redemption_instructions = $b1->items[0]->redemptionInstructions ?? '';
                if ($b1->status !== 'active') {
                    $reward->active = 0;
                }
                $reward->max_value = min($b1->items[0]->maxValue ?? 0, 1000000);
                $reward->tango_brand_requirements = json_encode($b1->brandRequirements);

                // new additions for tango - the above was taken from rewards
                $reward->currency = $b1->items[0]->currencyCode;

                // be careful with this!
                // this means if tango adds another reward it automatically passes to client!!

                $reward->save();
            }
        }

        return Command::SUCCESS;
    }
}
