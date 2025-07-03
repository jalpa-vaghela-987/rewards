<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email'                  => 'required|email',
            'company_name'           => 'required',
            'additional_information' => 'required',
            'g-recaptcha-response'   => 'required|captcha',
        ]);

        Mail::to('sales@perksweet.com')->send(new \App\Mail\ContactUs($validated));

        session()->flash('message', 'Our Sales Team Will Contact You Soon');

        return redirect()->back();
    }
}
