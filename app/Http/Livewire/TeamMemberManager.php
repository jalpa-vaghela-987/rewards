<?php

namespace App\Http\Livewire;

use App\Models\Team;
use App\Models\User;
use App\Notifications\InviteTeamMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\Actions\UpdateTeamMemberRole;
use Laravel\Jetstream\Contracts\AddsTeamMembers;
use Laravel\Jetstream\Contracts\RemovesTeamMembers;
use Laravel\Jetstream\Jetstream;
use Livewire\Component;

class TeamMemberManager extends Component
{
    public $search;
    public $searchResults = [];
    public $itemCollection = [];
    public $recipient;

    public $showAddNewTeamMemberModal;
    public $selectedTeam;
    public $showManagePermissionModal;
    public $selectedUser;
    public $teamIdFromMemberBeingRemoved;
    /**
     * The team instance.
     *
     * @var mixed
     */
    public $team;
    /**
     * The "add team member" form state.
     *
     * @var array
     */
    public $addTeamMemberForm = [
        'email' => '',
        'role' => null,
    ];
    /**
     * Indicates if a user's role is currently being managed.
     *
     * @var bool
     */
    public $currentlyManagingRole = false;
    /**
     * The user that is having their role managed.
     *
     * @var mixed
     */
    public $managingRoleFor;
    /**
     * The current role for the user that is having their role managed.
     *
     * @var string
     */
    public $currentRole;
    /**
     * Indicates if the application is confirming if a user wishes to leave the current team.
     *
     * @var bool
     */
    public $confirmingLeavingTeam = false;
    /**
     * Indicates if the application is confirming if a team member should be removed.
     *
     * @var bool
     */
    public $confirmingTeamMemberRemoval = false;
    /**
     * The ID of the team member being removed.
     *
     * @var int|null
     */
    public $teamMemberIdBeingRemoved = null;

    public $listeners = [
        'render',
        'team-member-added' => 'teamMemberAdded',
        'team-member-updated' => 'teamMemberUpdated',
        'close-manage-team-member-modal' => 'closeAddTeamMemberModal',
    ];

    public function render()
    {
        return view('livewire.team-member-manager');
    }

    /**
     * The "add team member" form state.
     *
     * @var array
     */

    /**
     * Mount the component.
     *
     * @param mixed $team
     * @return void
     */
    public function mount($team)
    {
        $this->team = $team;
        //        $this->dispatchBrowserEvent('notify', ['message' => 'Team Member  Deleted']);
        $this->itemCollection = Auth::user()
            ->company->users->where('active', 1)
            ->sortBy('name')
            ->reject(function ($value, $key) use ($team) {
                return in_array($value->id, $team->users->pluck('id')->toArray(), true);
            });
    }

    /**
     * Add a new team member to a team.
     *
     * @return void
     */
    public function addTeamMember()
    {
        $this->resetErrorBag();

        $this->validate([
                'recipient' => 'required',
            ], [
                'recipient.required' => 'Please select user.',
            ]);

        if ($this->recipient && $this->recipient->email) {
            app(AddsTeamMembers::class)->add(
                $this->user,
                $this->team,
                $this->recipient->email,
                $this->addTeamMemberForm['role']
            );

            $this->recipient->notify(new InviteTeamMember($this->team));

            $this->addTeamMemberForm = [
                'email' => '',
                'role' => null,
            ];

            $this->recipient = [];
            $this->search = '';

            $this->team = $this->team->fresh();

            $this->emit('saved');
            $this->dispatchBrowserEvent('notify', [
                'message' => 'Team Member Added',
            ]);
            $this->mount($this->team);
        }
    }

    /**
     * Get the current user of the application.
     *
     * @return mixed
     */
    public function getUserProperty()
    {
        return Auth::user();
    }

    /**
     * Get the available team member roles.
     *
     * @return array
     */
    public function getRolesProperty()
    {
        return array_values(Jetstream::$roles);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    // public function render()
    // {
    //     return view('livewire.team-member-manager');
    // }

    public function updatedSearch($newValue)
    {
        //dump("got to update");
        $search = $this->search;
        $filtered = $this->itemCollection->filter(function ($item) use (
            $search
        ) {
            return stripos($item['name'], $search) !== false;
        });

        $this->searchResults = $filtered;
    }

    public function addUser(User $u)
    {
        $this->recipient = $u;
        $this->searchResults = [];
    }

    public function manageRole($userId)
    {
        $this->currentlyManagingRole = true;
        $this->managingRoleFor = Jetstream::findUserByIdOrFail($userId);
        $role = $this->managingRoleFor->teamRole($this->team)->key;
        $this->currentRole = $role === 'owner' ? 'admin' : $role;
    }

    /**
     * Save the role for the user being managed.
     *
     * @param \Laravel\Jetstream\Actions\UpdateTeamMemberRole $updater
     * @return void
     */
    public function updateRole(UpdateTeamMemberRole $updater)
    {
        $updater->update(
            $this->user,
            $this->team,
            $this->managingRoleFor->id,
            $this->currentRole
        );

        $this->team = $this->team->fresh();

        $this->teamMemberUpdated();

        $this->stopManagingRole();
    }

    /**
     * Stop managing the role of a given user.
     *
     * @return void
     */
    public function stopManagingRole()
    {
        $this->currentlyManagingRole = false;
    }

    /**
     * Remove the currently authenticated user from the team.
     *
     * @param \Laravel\Jetstream\Contracts\RemovesTeamMembers $remover
     * @return
     */
    public function leaveTeam(RemovesTeamMembers $remover)
    {
        $remover->remove($this->user, $this->team, $this->user);

        $this->confirmingLeavingTeam = false;

        $this->team = $this->team->fresh();

        return redirect(config('fortify.home'));
    }

    /**
     * Confirm that the given team member should be removed.
     *
     * @param int $userId
     * @return void
     */
    public function confirmTeamMemberRemoval($userId)
    {
        $this->confirmingTeamMemberRemoval = true;

        $this->teamMemberIdBeingRemoved = $userId;
    }

    /**
     * Remove a team member from the team.
     *
     * @param \Laravel\Jetstream\Contracts\RemovesTeamMembers $remover
     * @return void
     */
    public function removeTeamMember(RemovesTeamMembers $remover)
    {
        $remover->remove($this->user, $this->team, Jetstream::findUserByIdOrFail($this->teamMemberIdBeingRemoved));

        $this->confirmingTeamMemberRemoval = false;

        $this->teamMemberIdBeingRemoved = null;

        $this->team = $this->team->fresh();
        $this->dispatchBrowserEvent('notify', [
            'message' => 'Team Member Deleted',
        ]);

        $this->render();

//        $this->mount($this->team);
    }

    //
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
