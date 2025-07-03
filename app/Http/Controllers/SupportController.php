<?php

namespace App\Http\Controllers;

class SupportController extends Controller
{
    public function help()
    {
        return view('support.help');
    }
}
