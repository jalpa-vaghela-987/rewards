<?php

namespace App\Jobs;

use App\Models\Company;
use App\Models\User;
use App\Models\UserInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class InviteChunkUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $users;
    public $company;
    public $format;
    public $admin_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($companyId, $users = [], $adminId = null)
    {
        $this->users = $users;
        $this->admin_id = $adminId;
        $this->company = $companyId instanceof Company ? $companyId : Company::find($companyId);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->users as $user) {
            $this->addUser($user, $this->company->id);
        }
    }

    public function getLevel($level)
    {
        return str_replace('level ', '', $level);
    }

    public function addUser($information, $companyId)
    {
        $alreadyInvitedUser = User::where('email', $information['email'])->first();
        $alreadyJoinedUser = (bool) data_get($alreadyInvitedUser, 'signed_up_at') ? $alreadyInvitedUser : null;

        if ($alreadyJoinedUser) {
            return;
        }

        if (! $alreadyInvitedUser) {
            $this->manageGhostUser($companyId, $information);

            $userInvitation = new UserInvitation;
            $userInvitation->set_up($this->company);
            if ($this->admin_id) {
                $userInvitation->sender_id = $this->admin_id;
            }
            $userInvitation->email = data_get($information, 'email');
            $userInvitation->role = (int) in_array($information['role'], ['admin', '1']) ? '1' : '2';
            $userInvitation->level = (int) $this->getLevel($information['level']);
            $userInvitation->save();
        } else {
            $userInvitation = $alreadyInvitedUser->invitation;

            $alreadyInvitedUser->created_at = now();
            $alreadyInvitedUser->save();

            $userInvitation->created_at = now();
            $userInvitation->save();
        }

        $userInvitation->send_invite();
    }

    public function getInvitation($email)
    {
        $invitation = UserInvitation::where('email', $email)->first();

        return (
            $invitation && $invitation->ghost_user
            && ! $invitation->ghost_user->signed_up_at
        ) ? $invitation : null;
    }

    public function manageGhostUser($companyId, $information, $user = null)
    {
        $user = $this->saveUserDetails($companyId, $information, $user);

        $this->addUserInSelectedTeams(data_get($information, 'selected_teams', []), $user);

        return $user;
    }

    public function saveUserDetails($companyId, $details, $user = null)
    {
        if (! $user) {
            $user = new User();
        }

        if (isset($details['name'])) {
            $parts = explode(" ", $details['name']);
            $user->name = $name = $details['name'];
            $user->last_name = array_pop($parts);
            $user->first_name = implode(" ", $parts);
        } else {
            $user->last_name = data_get($details, 'last_name');
            $user->first_name = data_get($details, 'first_name');
            $user->name = $name = trim(data_get($details, 'first_name'). ' ' .data_get($details, 'last_name'));
        }

        $user->initials = get_initials($name);
        $user->email = $details['email'];
        $user->password = bcrypt(data_get($details, 'password', Str::random(8)));
        $user->position = $details['title'];
        $user->birthday = data_get($details, 'birthday') ? '2000-'.$details['birthday'] : null;
        $user->anniversary = data_get($details, 'anniversary');
        $user->role = (int) in_array($details['role'], ['admin', '1']) ? '1' : '2';
        $user->level = (int) $this->getLevel($details['level']);
        if (data_get($details, 'selected_teams', [])) {
            $user->current_team_id = Arr::random(array_keys($details['selected_teams']));
        }
        $user->company_id = $companyId;
        $user->is_ghost = true;
        $user->created_at = now();
        $user->signed_up_at = null;
        $user->save();

        return $user;
    }

    public function addUserInSelectedTeams($selectedTeams, $user)
    {
        //todo: improve logic
        // foreach ($this->selected_teams as $teamId => $role) {
        //     $selectedTeams[$teamId] = ['role' => $role];
        // }

        if (count($selectedTeams)) {
            $user->teams()->sync($selectedTeams);
        }
    }
}
