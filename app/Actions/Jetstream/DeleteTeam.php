<?php

namespace App\Actions\Jetstream;

use Laravel\Jetstream\Contracts\DeletesTeams;

class DeleteTeam implements DeletesTeams
{
    /**
     * Delete the given team.
     *
     * @param mixed $team
     * @return void
     */
    public function delete($team)
    {
        if (auth()->user()->ownedTeams()->count() > 1) {
            $team->purge();
        }
    }

    public function forceDelete($team)
    {
        $team->purge();
    }
}
