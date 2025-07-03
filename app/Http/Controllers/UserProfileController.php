<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    /**
     * Show the user profile screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function show(Request $request, User $user = null)
    {
        if ($user && auth()->user()->role != 1 && $user->id != auth()->id()) {
            abort(404);
        }

        $user = $user ?? $request->user();

        return view('profile.show', [
            'request' => $request,
            'user' => $user,
        ]);
    }
}
