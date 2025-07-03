<?php

namespace App\Actions\Jetstream;

use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\Contracts\DeletesTeams;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    /**
     * The team deleter implementation.
     *
     * @var \Laravel\Jetstream\Contracts\DeletesTeams
     */
    protected $deletesTeams;

    /**
     * Create a new action instance.
     *
     * @param \Laravel\Jetstream\Contracts\DeletesTeams $deletesTeams
     * @return void
     */
    public function __construct(DeletesTeams $deletesTeams)
    {
        $this->deletesTeams = $deletesTeams;
    }

    /**
     * Delete the given user.
     *
     * @param mixed $user
     * @return void
     */
    public function delete($user)
    {
        DB::transaction(function () use ($user) {
            $user->forceFill([
                'active' => 0,
            ])->save();

            if ($user->meetingConfig && $user->meetingConfig->active) {
                $user->meetingConfig->active = 0;
                $user->meetingConfig->save();
            }

            auth()->logout();
        });
    }

    /**
     * Delete the teams and team associations attached to the user.
     *
     * @param mixed $user
     * @return void
     */
    protected function deleteTeams($user)
    {
        $user->teams()->detach();

        $user->ownedTeams->each(function ($team) {
            $this->deletesTeams->delete($team);
        });
    }
}
