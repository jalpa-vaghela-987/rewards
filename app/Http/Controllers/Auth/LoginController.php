<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (auth()->guard()->user()->active === 0) {
                auth()->logout();

                return redirect('login')->withErrors(['email' => 'These credentials do not match our records.']);
            }

            return redirect()->intended(RouteServiceProvider::HOME);
        }

        return redirect('login')->withErrors(['email' => 'These credentials do not match our records.']);
    }
}
