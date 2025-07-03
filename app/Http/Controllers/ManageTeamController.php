<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Jetstream\Jetstream;

class ManageTeamController extends Controller
{
    public function manage(Request $request)
    {
        Gate::authorize('manage', Jetstream::newTeamModel());

        return view('teams.manage', [
            'user' => $request->user(),
        ]);
    }
}
