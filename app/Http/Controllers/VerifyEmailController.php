<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;

class VerifyEmailController extends Controller
{
    public function __invoke($id, $hash)
    {
        $user = User::find($id);

        if (! hash_equals((string) $id, (string) $user->getKey()) || ! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403);
        }

        auth()->login($user);

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return response()->redirectToRoute('kudos.feed');
    }
}
