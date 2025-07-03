<?php

namespace App\Http\Livewire;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\Contracts\RemovesTeamMembers;
use Livewire\Component;

class InviteTeamMember extends Component
{
    public $confirmingLeavingTeam = false;
    public $confirmingTeamMemberRemoval = false;

    public $teamMemberIdBeingRemoved;
    public $teamIdFromMemberBeingRemoved;

    public $selectedTeam;
    public $selectedUser;
    public $showAddNewTeamMemberModal = false;
    public $showManagePermissionModal = false;

    public $listeners = [
        'render',
        'team-member-added' => 'teamMemberAdded',
        'team-member-updated' => 'teamMemberUpdated',
        'close-manage-team-member-modal' => 'closeAddTeamMemberModal',
    ];

    public function render()
    {
        return view('livewire.invite-team-member', [
            'teams' => auth()->user()->role === 1
                    ? auth()
                        ->user()
                        ->company->teams->sortBy('name')
                    : auth()
                        ->user()
                        ->teams->sortBy('name'),
        ]);
    }

    public function confirmTeamMemberRemoval($userId, $teamId)
    {
        $this->confirmingTeamMemberRemoval = true;

        $this->teamMemberIdBeingRemoved = $userId;

        $this->teamIdFromMemberBeingRemoved = $teamId;
    }

    public function confirmLeavingTeam($userId, $teamId)
    {
        $this->confirmingLeavingTeam = true;

        $this->teamMemberIdBeingRemoved = $userId;

        $this->teamIdFromMemberBeingRemoved = $teamId;
    }

    public function removeTeamMember(RemovesTeamMembers $remover)
    {
//        if ($this->preventActionIfOnlyAdminExistsInTeam()) {
//            return;
//        };

        $user = User::find($this->teamMemberIdBeingRemoved);

        $remover->remove(
            $user, Team::find($this->teamIdFromMemberBeingRemoved), $user
        );

        $this->confirmingTeamMemberRemoval = false;

        $this->teamMemberIdBeingRemoved = null;

        $this->teamIdFromMemberBeingRemoved = null;

        $this->dispatchBrowserEvent('notify', [
            'message' => 'Team Member Removed.',
        ]);
    }

    public function leaveTeam(RemovesTeamMembers $remover)
    {
//        if ($this->preventActionIfOnlyAdminExistsInTeam()) {
//            return;
//        };

        $user = User::find($this->teamMemberIdBeingRemoved);

        $remover->remove(
            $user, Team::find($this->teamIdFromMemberBeingRemoved), $user
        );

        $this->confirmingLeavingTeam = false;

        $this->dispatchBrowserEvent('notify', [
            'message' => 'You\'ve Left The Team.',
        ]);

        return redirect(config('fortify.home'));
    }

    public function preventActionIfOnlyAdminExistsInTeam()
    {
        if (
            //checking weather team has at least one admin user.
            ! DB::table('team_user')
                ->where('team_id', $this->teamIdFromMemberBeingRemoved)
                ->where('user_id', '!=', $this->teamMemberIdBeingRemoved)
                ->where('role', 'admin')
                ->count()
        ) {
            $this->reset([
                'confirmingTeamMemberRemoval',
                'teamMemberIdBeingRemoved',
                'teamIdFromMemberBeingRemoved',
                'confirmingLeavingTeam',
            ]);

            $this->dispatchBrowserEvent('notify', [
                'style'     => 'danger',
                'message'   => 'Can\'t remove user, selected user is only admin left in the team.',
            ]);

            return true;
        }

        return false;
    }

    public function openAddTeamMemberModal($teamId)
    {
        $this->selectedTeam = Team::find($teamId);

        $this->showAddNewTeamMemberModal = true;
    }

    public function closeAddTeamMemberModal()
    {
        $this->reset([
            'showAddNewTeamMemberModal',
            'showManagePermissionModal',
        ]);
        //        $this->reset(['selectedTeam']);
    }

    public function teamMemberAdded()
    {
        $this->closeAddTeamMemberModal();

        $this->dispatchBrowserEvent('notify', [
            'message' => 'Team member added.',
        ]);
    }

    public function teamMemberUpdated()
    {
        $this->closeAddTeamMemberModal();

        $this->dispatchBrowserEvent('notify', [
            'message' => 'Team member role updated.',
        ]);
    }

    public function manageModifyPermission($teamId, $userId)
    {
        $this->selectedTeam = Team::find($teamId);
        $this->selectedUser = User::find($userId);

        $this->showManagePermissionModal = true;
    }
}
