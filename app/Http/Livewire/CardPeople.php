<?php

namespace App\Http\Livewire;

use App\Models\Card;
use App\Models\Team;
use App\Models\User;
use Auth;
use Livewire\Component;

class CardPeople extends Component
{
    public $card;
    public $people = [];
    public $search;
    public $searchResults = [];
    public $itemCollection = [];

    public function mount(Card $card)
    {
        $this->card = $card;

        if (
            Auth::user()->hasTeams() &&
            Auth::user()->currentTeam &&
            count($this->card->users) < 1
        ) {
            //            foreach (Auth::user()->currentTeam->users as $u) {
            if (auth()->id() != $this->card->receiver->id) {
                // makes sure it's not the recipient
                $this->card->users()->attach(auth()->user(), ['active' => 1]);
            }
            //            }
        }

        if (count($this->card->users) < 1 && ! Auth::user()->hasTeams()) {
            $this->card->users()->attach(Auth::user(), ['active' => 1]);
        }

        $this->itemCollection = Auth::user()
            ->company->users->where('active', 1)
            ->sortBy('name');
    }

    public function render()
    {
        $this->people = $this->card
            ->users()
            ->wherePivot('active', '=', 1)
            ->get()
            ->sortBy('name');

        return view('livewire.card-people');
    }

    public function addFullCompanyUsers()
    {
        $this->itemCollection
            ->reject(function ($value, $key) {
                return $this->card->receiver->id === $value->id;
            })
            ->each(function ($user) {
                $this->addUser($user);
            });
    }

    public function addUser(User $u)
    {
        if (! $this->card->users->contains($u)) {
            $this->card->users()->attach($u, [
                'active' => 1,
            ]);
        } else {
            //checks if here, but set active to zero
            if (
                $this->card
                    ->users()
                    ->wherePivot('active', '=', 0)
                    ->get()
                    ->contains($u)
            ) {
                $u->cards()->updateExistingPivot($this->card->id, [
                    'active' => 1,
                ]);
            }
        }
        $this->reset('search', 'searchResults');
    }

    public function addFullTeamUsers(Team $team)
    {
        $team
            ->users()
            ->active()
            ->get()
            ->reject(function ($value, $key) {
                return $this->card->receiver->id === $value->id;
            })
            ->each(function ($user) {
                $this->addUser($user);
            });
    }

    public function removeFullTeamUsers(Team $team)
    {
        $team
            ->users()
            ->active()
            ->where('users.id', '!=', auth()->id())
            ->each(function ($user) {
                $this->removeUser($user);
            });
    }

    public function removeUser(User $u)
    {
        $u->cards()->updateExistingPivot($this->card->id, [
            'active' => 0,
        ]);
    }

    public function removeAllUsers()
    {
        foreach ($this->card->users as $u) {
            if ($u->id !== Auth::user()->id) {
                $u->cards()->updateExistingPivot($this->card->id, [
                    'active' => 0,
                ]);
            }
        }
    }

    public function updatedSearch($newValue)
    {
        $users = $this->card->users;
        $search = $this->search;

        $filtered = $this->itemCollection
            ->reject(function ($value, $key) use ($users) {
                return $this->card->receiver->id === $value->id;
            })
            ->filter(function ($item) use ($search) {
                return stripos($item['name'], $search) !== false;
            });

        $this->searchResults = $filtered;
    }
}
