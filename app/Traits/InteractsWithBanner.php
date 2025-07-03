<?php

namespace App\Traits;

trait InteractsWithBanner
{
    public function banner(string $message, string $style = 'success')
    {
        session()->flash('flash.banner', $message);
        session()->flash('flash.bannerStyle', $style);
    }
}
