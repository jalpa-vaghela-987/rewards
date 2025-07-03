<?php

namespace App\Actions\Jetstream;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\CreatesTeams;
use Laravel\Jetstream\Events\AddingTeam;
use Laravel\Jetstream\Jetstream;

class CreateTeam implements CreatesTeams
{
    public $team;

    /**
     * Validate and create a new team for the given user.
     *
     * @param mixed $user
     * @param array $input
     * @return mixed
     */
    public function create($user, array $input)
    {
        Gate::forUser($user)->authorize('create', Jetstream::newTeamModel());

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255', 'unique:teams'],
        ])->validateWithBag('createTeam');

        AddingTeam::dispatch($user);

        $user->switchTeam($team = $user->ownedTeams()->create([
            'name'          => $input['name'],
            'personal_team' => false,
        ]));
        /// Nick Code below ///

        $team->users()->attach(
            $user,
            ['role' => 'admin']);

        /// end nick code
        session()->flash('flash.banner', 'Team Created Successfully !');

        $this->team = $team;

        return $team;
    }

    public function redirectTo()
    {
        return route('teams.show', [$this->team->id]);
    }
}
