<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\UserInvitation;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Livewire\Component;

class AddUserByEmail extends Component
{
    public $first_name;
    public $last_name;
    public $title;
    public $email;
    public $role;
    public $level;
    public $password;
    public $teams = [];
    public $selected_teams = [];
    public $teamRoles = [
        'admin' => 'Team Administrator',
        'editor' => 'Team Member',
    ];

    public $invitation;

    public function mount($invitation = null)
    {
        if ($invitation) {
            /** @var User $user */
            $user = $invitation->ghost_user;
            $this->invitation = $invitation;

            $teams = $user->teams()->withPivot('role')->get();

            foreach ($teams as $team) {
                $this->selected_teams[$team->id] = $team->membership->role;
            }

            $this->first_name = $user->first_name;
            $this->last_name = $user->last_name;
            $this->title = $user->position;
            $this->email = $user->email;
            $this->role = $user->role;
            $this->level = $user->level;
        }
    }

    public function render()
    {
        $this->teams = auth()->user()->company->teams()->get();

        return view('livewire.add-user-by-email');
    }

    public function getRolesProperty()
    {
        return [
            (object) [
                'name' => 'Company Administrator',
                'key' => '1',
                'description' => 'Full company access with the ability to add users, remove users, upgrade user level, and manage company rewards.',
            ],
            (object) [
                'name' => 'Standard User',
                'key' => '2',
                'description' => 'Standard users may not modify any company settings.',
            ],
        ];
    }

    public function getLevelsProperty()
    {
        $company = auth()->user()->company;

        $levels = [
            (object) [
                'name' => 'Level 1',
                'key' => '1',
                'description' => 'Ability to give '.number_format($company->level_1_points_to_give).' '.getReplacedWordOfKudos().' per month',
            ],
            (object) [
                'name' => 'Level 2',
                'key' => '2',
                'description' => 'Ability to give '.number_format($company->level_2_points_to_give).' '.getReplacedWordOfKudos().' per month',
            ],
            (object) [
                'name' => 'Level 3',
                'key' => '3',
                'description' => 'Ability to give '.number_format($company->level_3_points_to_give).' '.getReplacedWordOfKudos().' per month',
            ],
            (object) [
                'name' => 'Level 4',
                'key' => '4',
                'description' => 'Ability to give '.number_format($company->level_4_points_to_give).' '.getReplacedWordOfKudos().' per month',
            ],
            (object) [
                'name' => 'Level 5',
                'key' => '5',
                'description' => 'Ability to give '.number_format($company->level_5_points_to_give).' '.getReplacedWordOfKudos().' per month',
            ],
        ];

        return $levels;
    }

    public function addNewUser()
    {
        $this->validate(
            [
                'first_name' => ['required', 'string', 'min:3', 'max:25'],
                'last_name' => ['required', 'string', 'min:3', 'max:25'],
                'email' => ['required', 'email:filter', 'unique:users,email', 'string', 'max:255'],
                'role' => ['required', 'integer', 'min:1', 'max:5'],
                'level' => ['required', 'integer', 'min:1', 'max:5'],
                'title' => ['nullable', 'string', 'max:30'],
//                'password' => ['required', 'min:8', 'max:16'],
//                            'selected_teams' => ['required', 'array'],
            ],
            [
//                            'selected_teams.required' => 'Please select at least one team',
            ]
        );

        if (
        $alreadyInvitedUser = User::active()
            ->where('email', $this->email)
            ->first()
        ) {
            if ($alreadyInvitedUser->signed_up_at) {
                return $this->addError('email', 'The given email already exists.');
            }
        } else {
            $this->manageGhostUser();
        }

        if (! $alreadyInvitedUser) {
            $userInvitation = new UserInvitation();
            $userInvitation->set_up();
            $userInvitation->email = $this->email;
            $userInvitation->role = $this->role;
            $userInvitation->level = $this->level;
            $userInvitation->save();
        } else {
            $userInvitation = $alreadyInvitedUser->invitation;

            $alreadyInvitedUser->created_at = now();
            $alreadyInvitedUser->save();

            $userInvitation->created_at = now();
            $userInvitation->save();
        }

        $userInvitation->send_invite();

        $this->reset();

        $this->emit('saved');
        $this->emit('refreshCompanyUsers');
    }

    public function manageGhostUser($user = null)
    {
        $user = $this->saveUserDetails($user);

        $this->addUserInSelectedTeams($user);

        return $user;
    }

    public function saveUserDetails($user = null)
    {
        if (! $user) {
            $user = new User();
        }

        $fullName = collect([$this->first_name, $this->last_name])
            ->filter()
            ->implode(' ');

        $user->name = trim($fullName);
        $user->first_name = trim($this->first_name);
        $user->last_name = trim($this->last_name);
        $user->initials = get_initials(trim($fullName));
        $user->email = $this->email;
        $user->password = bcrypt($this->password ?? Str::random(8));
        $user->position = $this->title;
        $user->role = $this->role;
        $user->level = $this->level;
        $user->current_team_id = count($this->selected_teams) ? Arr::random(array_keys($this->selected_teams)) : null;
        $user->company_id = auth()->user()->company_id;
        $user->is_ghost = true;
        $user->created_at = now();
        $user->signed_up_at = null;
        $user->save();

        return $user;
    }

    public function addUserInSelectedTeams($user)
    {
        $selectedTeams = [];

        foreach ($this->selected_teams as $teamId => $role) {
            $selectedTeams[$teamId] = ['role' => $role];
        }

        $user->teams()->sync($selectedTeams);
    }

    public function addToTeam($teamId, $defaultRole = 'editor')
    {
        if (isset($this->selected_teams[$teamId])) {
            unset($this->selected_teams[$teamId]);
        } else {
            $this->selected_teams[$teamId] = $defaultRole;
        }
    }

    public function selectRole($teamId, $role)
    {
        if (isset($this->selected_teams[$teamId])) {
            $this->selected_teams[$teamId] = $role;
        }
    }

    public function roleSelectedForTeam($teamId, $role)
    {
        if (isset($this->selected_teams[$teamId])) {
            return $this->selected_teams[$teamId] == $role;
        }

        return false;
    }

    public function teamSelected($teamId)
    {
        return array_key_exists((string) $teamId, $this->selected_teams);
    }

    public function getInvitation($email)
    {
        $invitation = UserInvitation::where('email', $email)->first();

        return $invitation && $invitation->ghost_user && ! $invitation->ghost_user->signed_up_at
            ? $invitation
            : null;
    }

    public function updateInvitation($sendInvitation = false)
    {
        $this->validate(
            [
                'first_name' => ['required', 'string', 'min:3', 'max:25'],
                'last_name' => ['required', 'string', 'min:3', 'max:25'],
                'role' => ['required', 'integer', 'min:1', 'max:5'],
                'level' => ['required', 'integer', 'min:1', 'max:5'],
                'title' => ['nullable', 'string', 'max:30'],
                //            'password'          => ['required', 'min:8', 'max:16'],
                //            'selected_teams' => ['required', 'array'],
            ],
            [
                //            'selected_teams.required' => 'Please select atleast one team.',
            ]
        );

        if ($oldInvitation = $this->invitation) {
            $oldInvitation->delete();

            if ($oldInvitation->email !== $this->email && $this->invitation->ghost_user) {
                $this->invitation->ghost_user->delete();
            }
        }

        $invitation = new UserInvitation();
        $invitation->set_up();
        $invitation->email = $this->email;
        $invitation->role = $this->role;
        $invitation->level = $this->level;
        $invitation->save();

        $this->invitation = $invitation;

        $this->manageGhostUser($this->invitation->ghost_user);

        if ($sendInvitation) {
            $this->invitation->send_invite();
        }

        session()->flash('flash.banner', $sendInvitation ? 'Invitation Sent!' : 'Invitation Updated!');

        $this->redirectRoute('company.manage-invites');
    }

    public function updateGhostUser($user)
    {
        $user = $this->saveUserDetails($user);

        $this->addUserInSelectedTeams($user);

        return $user;
    }
}
