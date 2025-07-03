<?php

namespace App\Http\Controllers;

use App\Models\Gif;
use Illuminate\Support\Facades\Http;
use Storage;

class GifController extends Controller
{
    //

    public function pull()
    {

//Giphy below
        //    	$to = "api.giphy.com/v1/gifs/search";
        //    	$q = "puppy";
        //    return $response = Http::get($to, [
        //     'api_key' => config('app.giphy_key'),
        //     'q' => $q,
        // ]);
        //giphy load
        // $json = Storage::disk('local')->get('puppy.json');
        // $json = json_decode($json, true);

        //    $response = $json;
        //    $gif1 = $response['data'][0]['embed_url'];
        //return dump($response);
        //return dump($response['data'][0]);

        //tenor below
        //    	$to = "https://g.tenor.com/v1/search";
        //    	$q = "puppy";
        //    $response = Http::get($to, [
        //    'key' => config('app.tenor_key'),
        //     'q' => $q,
        //     'contentfilter' => 'high',
        //     'media_filter' => 'minimal',
        //     'ar_range' => 'standard'

        // ]);

        // //dump($response->getBody()->getContents());
        // $content = json_decode($response->getBody()->getContents());
        // //dump($content->results[0]);

        // $gif1 = $content->results[0]->media[0]->gif->url;
        // //dump($gif1);

        // $gif = new Gif;
        // $gifs = $gif->search('kitten');

        // $gif = new Gif;
        // return $gif->test();

        return view('gif.test2');
    }
}
