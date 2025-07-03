<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use App\Models\Tango;
use Illuminate\Support\Facades\Http;

class TangoController extends Controller
{
    private $key;
    private $endpoint;
    private $platform;

    public function __construct()
    {
        $this->key = env('TANGO_API_KEY', '');
        $this->endpoint = env('TANGO_ENDPOINT', '');
        $this->platform = env('TANGO_PLATFORM', '');
    }

    public function update()
    {
        $key = $this->key;
        $endpoint = $this->endpoint;
        $platform = $this->platform;

        $response = Http::withBasicAuth($platform, $key)->get($endpoint.'catalogs', []);

        $body = ((json_decode($response->body())));
        if (! $body || ! isset($body->brands)) {
            return;
        }

        $brands = $body->brands;
//        dd($brands);
        foreach ($brands as $b1) {
            //$b1 = $brands[0];
            //echo "here";

            //dd($b1);
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
                // echo $reward->title." --- ";
                // echo ($b1->items[0]->maxValue );
                // echo "<br>";
                $reward->max_value = min($b1->items[0]->maxValue ?? 0, 1000000);
                $reward->tango_brand_requirements = json_encode($b1->brandRequirements);

                // new additions for tango - the above was taken from rewards
                $reward->currency = $b1->items[0]->currencyCode;

                // be careful with this!
                // this means if tango adds another reward it automatically passes to client!!

                $reward->save();

                //dd($reward);
            }
            // echo '"'.($reward->tango_utid).'", '.' // '.$reward->title;
            // echo "<br>";
        }

        return back();
    }

    // public function get_active_rewards(){

    //     "U561621", // adidas Gift Card
    //     "U986050", // Airbnb Gift Card
    //     "U350230", // Amazon.ca Gift Certificate
    //     "U666425", // Amazon.com Gift Card
    //     "U555541", // AMC Theatres® e-Gift Card
    //     "U291543", // Applebee’s® eGift Card
    //     "U930246", // Athleta eGift Card
    //     "U676010", // Auntie Anne's eGift Card
    //     "U469609", // Banana Republic eGift Card
    //     "U318911", // Bass Pro Shops® eGift Card
    //     "U728067", // Bath & Body Works eGift Card
    //     "U186495", // Bed Bath & Beyond® eGift Card
    //     "U996596", // Best Buy® e-Gift Card
    //     "U810083", // Bloomin' Brands eGiftCard
    //     "U203426", // Buffalo Wild Wings® eGift Card
    //     "U475375", // Carvel eGift Card
    //     "U714697", // Chili's eGift Card
    //     "U714697", // Chili's eGift Card
    //     "U869049", // Cold Stone® eGift Card
    //     "U851147", // Crate and Barrel eGift Card
    //     "U516600", // Darden eGift Card
    //     "U972783", // Delta eGift Card
    //     "U833675", // Dicks Sporting Goods Online Gift Certificate
    //     "U012700", // Domino's eGift Card
    //     "U964209", // DoorDash Gift Card
    //     "U407739", // Grubhub Gift Card
    //     "U354267", // HomeGoods eGift Card
    //     "U589797", // Lowe's E-Gift Card
    //     "U023719", // Marshalls eGift Card
    //     "U523844", // Moe's Southwest Grill eGift Card
    //     "U320784", // Nike Digital Gift Card
    //     "U766649", // Nordstrom eGift Card
    //     "U455508", // Panera Bread eGift Card
    //     "U469706", // Petco eGift Card
    //     "U151008", // Roots e-Gift Card (Canada)
    //     "U557938", // Southwest® Gift Card
    //     "U875141", // Spa & Wellness Gift Card by Spa Week
    //     "U477356", // Spafinder Wellness 365™ eGift Card
    //     "U761382", // Starbucks eGift
    //     "U761382", // Starbucks eGift
    //     "U084922", // Target eGiftCard
    //     "U231646", // The Home Depot® eGift Card
    //     "U033028", // The Home Depot® Canada eGift Card
    //     "U553871", // TJX eGift Card
    //     "U364643", // Topgolf eGift Card
    //     "U552132", // Uber Gift Card
    //     "U517295", // Uber Eats Gift Card
    //     "U396551", // Under Armour® eGift Card
    //     "U640032", // Walmart eGift Card

    // }

    public function print_available_rewards()
    {
        $key = $this->key;
        $endpoint = $this->endpoint;
        $platform = $this->platform;

        $response = Http::withBasicAuth($platform, $key)->get($endpoint.'catalogs', []);

        $body = ((json_decode($response->body())));
        if (! $body || ! isset($body->brands)) {
            return;
        }

        $brands = $body->brands;
        //dd($brands);
        foreach ($brands as $b1) {
            //$b1 = $brands[0];
            //echo "here";
            if ($b1->items[0]->valueType === 'VARIABLE_VALUE') {
                $reward = new Reward;
                $reward->title = $b1->items[0]->rewardName;
                $hold = '300w-326ppi'; //errored since the dash was there
                $reward->photo_path = $b1->imageUrls->$hold;
                $reward->description = $b1->shortDescription;
                $reward->min_value = max($b1->items[0]->minValue ?? 0, 10);
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
                $reward->max_value = min($b1->items[0]->maxValue ?? 0, 100);
                $reward->tango_brand_requirements = json_encode($b1->brandRequirements);
                //$reward->save();
            }
            echo '"'.($reward->tango_utid).'", '.' // '.$reward->title;
            echo '<br>';
        }
    }
}
