<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Gif extends Model
{
    use HasFactory;

    public $key;
    public $to = 'https://g.tenor.com/v1/search';
    public $contentfilter = 'low';
    public $media_filter = 'minimal';
    public $ar_range = 'standard';
    public $limit = 30;
    public $next = '';
    public $q = '';
    public $urls = [];

    public function __construct()
    {
        $this->key = config('app.tenor_key');
        $this->urls = collect([]);
    }

    public function search($q, $next = '')
    {
        $response = Http::get($this->to, [
            'key' => $this->key,
            'q' => $q,
            'contentfilter' => $this->contentfilter,
            'media_filter' => $this->media_filter,
            'ar_range' => $this->ar_range,
            'limit' => 50,
            'pos' => $next,
        ]);

        $content = json_decode($response->getBody()->getContents());

        foreach ($content->results as $g) {
            $url = $g->media[0]->gif->url;
            $this->urls->push($url);
        }

        return collect([$this->urls, $content->next]);
    }

    public function test()
    {
        $response = Http::get($this->to, [
            'key' => $this->key,
            'q' => 'dogs',
            'contentfilter' => $this->contentfilter,
            'media_filter' => $this->media_filter,
            'ar_range' => $this->ar_range,
            'limit' => 50,
            'pos' => '',
        ]);

        $content = json_decode($response->getBody()->getContents());

        return dump($content->next);

        //return $response->getBody()->getContents();
    }

    public function search_x($q, $n = 2, $next = 0)
    {
        if (! $q) {
            return collect([]);
        }
        $this->urls = collect([]);

        for ($i = 0; $i < $n; $i++) {
            $response = Http::get($this->to, [
                'key' => $this->key,
                'q' => $q,
                'contentfilter' => $this->contentfilter,
                'media_filter' => $this->media_filter,
                'ar_range' => $this->ar_range,
                'limit' => 50,
                'pos' => $next,
            ]);

            $content = json_decode($response->getBody()->getContents());
            $next = $content->next;

            //dump($next);
            foreach ($content->results as $g) {
                $url = $g->media[0]->gif->url;
                $this->urls->push($url);
            }
        }

        return collect([$this->urls, $next]);
    }
}
