<?php

namespace App\Http\Livewire;

use App\Models\Company;
use App\Models\User;
use App\Notifications\InviteTeamMember;
use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\Contracts\AddsTeamMembers;
use Laravel\Jetstream\Jetstream;
use Livewire\Component;

class AddTeamMember extends Component
{
    public $team;

    public $search;
    public $searchResults = [];
    public $itemCollection = [];
    public $recipient;

    public $roles = [];

    public $editingUser;
    public $selectedRole;

    /**
     * The "add team member" form state.
     *
     * @var array
     */
    public $addTeamMemberForm = [
        'email' => '',
        'role' => null,
    ];

    public function getRolesProperty()
    {
        return array_values(Jetstream::$roles);
    }

    public function mount($team, $user = null)
    {
        $this->team = $team;

        if ($user && $team) {
            $this->editingUser = $user;

            $this->addTeamMemberForm['role'] = data_get(
                DB::table('team_user')
                    ->where('team_id', $team->id)
                    ->where('user_id', $this->editingUser->id)
                    ->first(),
                'role'
            );
        }

        $this->roles = $this->getRolesProperty();
    }

    public function render()
    {
        return view('livewire.add-team-member');
    }

    public function updatedSearch($newValue)
    {
        /** @var Company $company * */
        $company = \auth()->user()->company;

        if ($this->search) {
            $this->searchResults = $company
                ->users()
                ->where('active', 1)
                ->whereNotIn(
                    'id',
                    $this->team
                        ->users()
                        ->pluck('users.id')
                        ->toArray()
                )
                ->where('name', 'like', "%$this->search%")
                ->orderBy('name')
                ->skip(0)
                ->take(3)
                ->get();
        }
    }

    public function addUser(User $user)
    {
        $this->recipient = $user;

        $this->searchResults = [];
    }

    public function addTeamMember()
    {
        $this->resetErrorBag();

        $this->validate(
            [
                'recipient' => 'required',
            ],
            [
                'recipient.required' => 'Please select user.',
            ]
        );

        if ($this->recipient && $this->recipient->email) {
            app(AddsTeamMembers::class)->add(
                auth()->user(),
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

            $this->emit('team-member-added');

            $this->emitUp('render');

            $this->mount($this->team);
        }
    }

    public function isRoleSelected($role)
    {
        return data_get($role, 'key') === $this->addTeamMemberForm['role'];
    }

    public function updateMember()
    {
        $this->resetErrorBag();

        $this->selectedRole =
            $this->addTeamMemberForm['role'] ??
            data_get($this->roleNames, $this->editingUser->role);

        $this->validate(
            [
                'selectedRole' => 'required',
            ],
            [
                'selectedRole.required' => 'Please select role.',
            ]
        );

        if ($this->selectedRole && $this->editingUser) {
            if (
                $this->selectedRole === 'editor' &&
                ! DB::table('team_user')
                    ->where('team_id', $this->team->id)
                    ->where('user_id', '!=', $this->editingUser->id)
                    ->where('role', 'admin')
                    ->count()
            ) {
                return $this->addError(
                    'role',
                    'Can\'t change role, selected user is only admin left in the team.'
                );
            }

            $teamRoleQuery = DB::table('team_user')
                ->where('team_id', $this->team->id)
                ->where('user_id', $this->editingUser->id);

            if ($teamRoleQuery->exists()) {
                $teamRoleQuery->update(['role' => $this->selectedRole]);
            }

            $this->team = $this->team->fresh();

            $this->emit('team-member-updated');

            $this->emitUp('render');

            $this->mount($this->team);
        }
    }
}
