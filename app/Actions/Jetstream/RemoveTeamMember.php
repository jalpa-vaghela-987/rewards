<?php

namespace App\Actions\Jetstream;

use App\Models\Team;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Contracts\RemovesTeamMembers;
use Laravel\Jetstream\Events\TeamMemberRemoved;

class RemoveTeamMember implements RemovesTeamMembers
{
    /**
     * Remove the team member from the given team.
     *
     * @param  mixed  $user
     * @param  mixed  $team
     * @param  mixed  $teamMember
     * @return void
     */
    public function remove($user, $team, $teamMember)
    {
        $this->authorize($user, $team, $teamMember);

        // https://trello.com/c/FgdbgEOj/191-manage-teams-changes - allow team admin to leave team, if only admin exists in team
        //  https://trello.com/c/K54g8SzB/400-top-priority-allow-team-creator-to-leave
//        $this->userCanBeRemovedFromTeam($teamMember, $team);
//        $this->ensureUserDoesNotOwnTeam($teamMember, $team);

        $team->removeUser($teamMember);

        $team->setRandomOwner($teamMember);

        TeamMemberRemoved::dispatch($team, $teamMember);
    }

    /**
     * Authorize that the user can remove the team member.
     *
     * @param  mixed  $user
     * @param  mixed  $team
     * @param  mixed  $teamMember
     * @return void
     */
    protected function authorize($user, $team, $teamMember)
    {
        if (! Gate::forUser($user)->check('removeTeamMember', $team) &&
            $user->id !== $teamMember->id) {
            throw new AuthorizationException;
        }
    }

    /**
     * Ensure that the currently authenticated user does not own the team.
     *
     * @param  mixed  $teamMember
     * @param  mixed  $team
     * @return void
     */
    protected function ensureUserDoesNotOwnTeam($teamMember, $team)
    {
        if ($teamMember->id === $team->owner->id) {
            throw ValidationException::withMessages([
                'team' => [__('You may not leave a team that you created.')],
            ])->errorBag('removeTeamMember');
        }
    }

    protected function userCanBeRemovedFromTeam($teamMember, $team)
    {
        if ($teamMember->role == 1 && ! $this->anotherAdminExistsInTeam($teamMember, $team)) {
            throw ValidationException::withMessages([
                'team' => [__('Another admin should exists to leave a team.')],
            ])->errorBag('removeTeamMember');
        }
    }

    protected function anotherAdminExistsInTeam($teamMember, $team)
    {
        return $team->admins()->where('users.id', '!=', $teamMember->id)->exists();
    }
}
