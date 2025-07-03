<?php

namespace App\Http\Livewire;

use App\Models\Team;
use App\Models\User;
use Livewire\Component;

class AdminKudosGifting extends Component
{
    public $search;
    public $searchResults = [];
    public $recipients = [];
    public $recipient_search;
    public $selected_recipients = [];
    public $is_recipient_showing = '';

    public function mount()
    {
        $userIds = old('user_id', []);
        if ($userIds && (is_array($userIds) && count($userIds))) {
            $this->selected_recipients = \App\Models\User::whereIn('id', old('user_id', []))
                ->pluck('name', 'id')
                ->toArray();
        }
    }

    public function render()
    {
        return view('livewire.admin-kudos-gifting');
    }

    public function updatedSearch()
    {
        $userIds = [];

        foreach ($this->selected_recipients as $id => $name) {
            $userIds[] = $id;
        }
        if ($this->search) {
            $this->searchResults = User::where(function ($q) {
                $q->where('first_name', 'like', "$this->search%")
                        ->orWhere('last_name', 'like', "$this->search%");
            })
                ->where('active', 1)
                ->where('company_id', auth()->user()->company_id)
                ->whereNotIn('id', $userIds)
                ->where('id', '!=', auth()->user()->id)
                ->orderBy('name')
                ->take(5)
                ->get();

            $this->is_recipient_showing = '';
        } else {
            $this->reset('search', 'searchResults');
        }
    }

    public function selectRecipient($user)
    {
        $this->selected_recipients[$user->id] = $user->name;
    }

    public function addUser($user, $resetInputs = true)
    {
        $userId = data_get($user, 'id');
        $userName = data_get($user, 'name');

        if (
            ! isset($this->selected_recipients[$userId]) &&
            $userId !== auth()->id()
        ) {
            $this->selected_recipients[$userId] = $userName;
        }

        if ($resetInputs) {
            $this->reset('search', 'searchResults');
        }
    }

    public function addFullCompanyUsers()
    {
        foreach (auth()->user()->company->users()->pluck('name', 'id')->toArray() as $id => $name) {
            $this->addUser((object) ['id' => $id, 'name' => $name], false);
        }
    }

    public function addFullTeamUsers($teamId)
    {
        $team = Team::find($teamId);

        foreach ($team->users()->active()->pluck('users.name', 'users.id')->toArray() as $id => $name) {
            $this->addUser((object) ['id' => $id, 'name' => $name], false);
        }
    }

    public function removeFullTeamUsers($teamId)
    {
        $team = Team::find($teamId);

        foreach ($team->users()->active()->pluck('users.name', 'users.id')->toArray() as $id => $name) {
            $this->removeUser($id);
        }
    }

    public function removeUser($userId)
    {
        if (isset($this->selected_recipients[$userId])) {
            unset($this->selected_recipients[$userId]);
        }
    }

    public function removeAllUsers()
    {
        $this->selected_recipients = [];
    }
}
