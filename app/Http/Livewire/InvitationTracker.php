<?php

namespace App\Http\Livewire;

use App\Models\UserInvitation;
use Auth;
use Livewire\Component;
use Livewire\WithPagination;

class InvitationTracker extends Component
{
    use WithPagination;

    public $perPage = 10000;

    public $confirmingLeavingTeam;
    public $confirmingCompanyMemberRemoval = false;

    public $showModifyPermission = false;

    public $selectedUser;
    public $role;
    public $level;

    protected $listeners = ['saved' => '$refresh'];

    public function render()
    {
        $emails = auth()
            ->user()
            ->company->users()
            ->whereNotNull('signed_up_at')
            ->pluck('email');

        $users = auth()
            ->user()
            ->company->userInvitations->where('active', 1)
            ->sortByDesc('created_at')
            ->filter(function ($value, $key) use ($emails) {
                if (! $emails->contains($value->email)) {
                    return $value;
                }
            });

        return view('livewire.invitation-tracker', ['items' => $users]);
    }

    public function getRolesProperty()
    {
        $roles = [
            (object) [
                'name' => 'Admin',
                'key' => '1',
                'description' => 'Full company access with the ability to add users, remove users, upgrade user level, and create new admin users.',
            ],
            (object) [
                'name' => 'Standard',
                'key' => '2',
                'description' => 'Standard User. Cannot add or remove users or change company settings.',
            ],
        ];

        return $roles;
    }

    public function getLevelsProperty()
    {
        $company = Auth::user()->company;

        $levels = [
            (object) [
                'name' => 'Level 1',
                'key' => '1',
                'description' => 'Ability to give '.
                    number_format($company->level_1_points_to_give).
                    ' Kudos per month',
            ],
            (object) [
                'name' => 'Level 2',
                'key' => '2',
                'description' => 'Ability to give '.
                    number_format($company->level_2_points_to_give).
                    ' Kudos per month',
            ],
            (object) [
                'name' => 'Level 3',
                'key' => '3',
                'description' => 'Ability to give '.
                    number_format($company->level_3_points_to_give).
                    ' Kudos per month',
            ],
            (object) [
                'name' => 'Level 4',
                'key' => '4',
                'description' => 'Ability to give '.
                    number_format($company->level_4_points_to_give).
                    ' Kudos per month',
            ],
            (object) [
                'name' => 'Level 5',
                'key' => '5',
                'description' => 'Ability to give '.
                    number_format($company->level_5_points_to_give).
                    ' Kudos per month',
            ],
        ];

        return $levels;
    }

    public function cancel()
    {
        $this->reset(['showModifyPermission', 'selectedUser', 'role', 'level']);
    }

    public function confirmCompanyMemberRemoval($invitationId)
    {
        $this->confirmingCompanyMemberRemoval = true;

        $this->selectedUser = $invitationId;
    }

    public function removeCompanyMember()
    {
        if ($invitation = UserInvitation::findOrFail($this->selectedUser)) {
            if ($invitation->ghost_user) {
                $invitation->ghost_user->teams()->sync([]);
                $invitation->ghost_user
                    ->forceFill([
                        'active' => 0,
                    ])
                    ->save();
                //                $invitation->ghost_user->delete();
            }

            $invitation->delete();
        }

        $this->selectedUser = null;
        $this->confirmingCompanyMemberRemoval = false;
    }
}
