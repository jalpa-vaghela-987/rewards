<?php

namespace App\Http\Controllers;

use Vimeo\Vimeo;

class VimeoController extends Controller
{
    private $client_id;
    private $token;
    private $oauth_url;
    private $access_token_url;

    public function __construct()
    {
        $this->client_id = env('VIMEO_CLIENT_ID', '');
        $this->token = env('VIMEO_TOKEN', '');
        $this->oauth_url = env('VIMEO_OAUTH_URL', '');
        $this->access_token_url = env('VIMEO_ACCESS_TOKEN_URL');
        $this->access_token = env('VIMEO_ACCESS_TOKEN');
    }

    public function test()
    {
        $client = new Vimeo($this->client_id, $this->token, $this->access_token);
        //return;
        $arr = '{
                  "upload": {
                    "approach": "post",
                    "size": "1000000",
                    "redirect_url": "perksweet.com"
                  }
                }';

        $response = $client->request('/me/videos',
        [

            'headers' => ['Content-Type' => 'application/json',
            'authorization_code'=>$this->access_token,
        ],
            'body'=>$arr,

        ], 'POST');
        print_r($response);

        //POSThttps://api.vimeo.com/me/videos

      //https://developer.vimeo.com/api/upload/videos
    }
}
