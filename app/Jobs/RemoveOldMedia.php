<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class RemoveOldMedia implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $path;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->removeOldMedia($this->path);
    }

    public function removeOldMedia($path)
    {
        if (! $path) {
            return;
        }

        if (str_contains($path, 'perksweet-uploads.s3.amazonaws.com')) {
            $urlParts = explode('perksweet-uploads.s3.amazonaws.com', $path);
            $path = trim(last($urlParts), '/');
        }

        if (Storage::disk('s3')->exists($path)) {
            Storage::disk('s3')->delete($path);
        }

        if (is_numeric($path)) {
            Http::withHeaders([
                'Authorization' => 'Bearer '.env('VIMEO_ACCESS_TOKEN'),
            ])->delete("https://api.vimeo.com/videos/$path");
        }
    }
}
