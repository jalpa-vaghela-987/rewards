<?php

namespace App\Http\Controllers;

use App\Models\User;

class TestController extends Controller
{
    public function updateFirstNameAndLastName()
    {
        $users = User::select(['id', 'name', 'first_name', 'last_name'])->get();

        foreach ($users as $user) {
            $data = explode(' ', $user['name']);

            $user->update([
                'first_name' => data_get($data, '0'),
                'last_name'  => data_get($data, '1'),
            ]);
        }

        return response()->json('success');
    }
}
