<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

class UserController extends Controller
{
    public function transactions()
    {
        $transactions = Transaction::where('user_id', auth()->user()->id)->latest()->paginate(25);

        return view('user.transactions', compact('transactions'));
    }

    public function rewardRedemption()
    {
        return view('user.rewards');
    }

    public function people()
    {
        return view('user.people');
    }

    public function specialDays()
    {
        return view('user.special-days');
    }
}
