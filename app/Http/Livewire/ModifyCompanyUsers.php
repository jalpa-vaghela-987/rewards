<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ModifyCompanyUsers extends Component
{
    use WithPagination;

    public $perPage = 25;

    public $confirmingLeavingTeam;
    public $confirmingCompanyMemberRemoval = false;

    public $showModifyPermission = false;

    public $selectedUser;
    public $role;
    public $level;
    public $search;

    protected $listeners = [
        'refreshCompanyUsers' => 'render',
    ];

    public function loadMore()
    {
        $this->perPage += 25;
    }

    public function render()
    {
        $users = auth()
            ->user()
            ->company->users()
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%'.$this->search.'%');
            })
            ->where('active', 1)
            ->orderBy('name')
            ->paginate(50);

        return view('livewire.modify-company-users', [
            'users' => $users,
        ]);
    }

    public function cancel()
    {
        $this->reset(['showModifyPermission', 'selectedUser', 'role', 'level']);
    }

    public function confirmCompanyMemberRemoval($userId)
    {
        $this->confirmingCompanyMemberRemoval = true;

        $this->selectedUser = $userId;
    }

    public function removeCompanyMember()
    {
        if ($user = User::findOrFail($this->selectedUser)) {
            if (
                $user->role == '1' &&
                ! User::where('role', 1)
                    ->company(auth()->user()->company_id)
                    ->whereNotNull('signed_up_at')
                    ->where('id', '!=', $user->id)
                    ->exists()
            ) {
                $this->reset([
                    'selectedUser',
                    'confirmingCompanyMemberRemoval',
                ]);

                $this->dispatchBrowserEvent('notify', [
                    'timeout' => 5000,
                    'style' => 'danger',
                    'message' => 'Can\'t remove user, Company should have at least one admin.',
                ]);

                return;
            }

            if ($user->signed_up_at) {
                $user->forceFill(['active' => 0])->save();
            } else {
                if ($user->invitation) {
                    $user->invitation->delete();
                }

                $user->delete();
            }

            if (
                $user->signed_up_at &&
                $user->meetingConfig &&
                $user->meetingConfig->active
            ) {
                $user->meetingConfig->active = 0;
                $user->meetingConfig->save();
            }

            $this->reset(['selectedUser', 'confirmingCompanyMemberRemoval']);

            $this->dispatchBrowserEvent('notify', [
                'message' => 'User removed from the company.',
                'timeout' => 3000,
            ]);
        }

        $this->reset(['selectedUser', 'confirmingCompanyMemberRemoval']);
    }

    public function manageModifyPermission(User $user)
    {
        $this->selectedUser = $user;

        $this->role = $user->role;
        $this->level = $user->level;

        $this->showModifyPermission = true;
    }

    public function modifyPermission()
    {
        $user = User::find($this->selectedUser->id);

        if (
            $user->role == '1' &&
            $this->role != '1' &&
            ! User::where('role', 1)
                ->whereNotNull('signed_up_at')
                ->where('id', '!=', $this->selectedUser->id)
                ->company(auth()->user()->company_id)
                ->exists()
        ) {
            return $this->addError(
                'role',
                'Can\'t change role, Company should have at least one admin.'
            );
        }

        $user->role = $this->role;
        $user->level = $this->level;
        $user->save();

        $this->showModifyPermission = false;

        $this->reset(['showModifyPermission', 'selectedUser', 'role', 'level']);

        $this->dispatchBrowserEvent('notify', [
            'message' => 'Permissions Updated.',
        ]);
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
        $company = auth()->user()->company;

        $levels = [
            (object) [
                'name' => 'Level 1',
                'key' => '1',
                'description' => 'Ability to give '.
                    number_format($company->level_1_points_to_give).
                    ' '.
                    getReplacedWordOfKudos().
                    ' per month',
            ],
            (object) [
                'name' => 'Level 2',
                'key' => '2',
                'description' => 'Ability to give '.
                    number_format($company->level_2_points_to_give).
                    ' '.
                    getReplacedWordOfKudos().
                    ' per month',
            ],
            (object) [
                'name' => 'Level 3',
                'key' => '3',
                'description' => 'Ability to give '.
                    number_format($company->level_3_points_to_give).
                    ' '.
                    getReplacedWordOfKudos().
                    ' per month',
            ],
            (object) [
                'name' => 'Level 4',
                'key' => '4',
                'description' => 'Ability to give '.
                    number_format($company->level_4_points_to_give).
                    ' '.
                    getReplacedWordOfKudos().
                    ' per month',
            ],
            (object) [
                'name' => 'Level 5',
                'key' => '5',
                'description' => 'Ability to give '.
                    number_format($company->level_5_points_to_give).
                    ' '.
                    getReplacedWordOfKudos().
                    ' per month',
            ],
        ];

        return $levels;
    }
}
