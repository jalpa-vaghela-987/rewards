<?php

namespace App\Http\Livewire;

use App\Models\Point;
use App\Models\User;
use Livewire\Component;

class DashBoard extends Component
{
    public $current_team;
    public $team_only = false;

    // for search
    public $search;
    public $searchResults = [];
    public $itemCollection = [];
    public $recipient = false;
    public $is_showing = '';
    //public $paginator = $this->paginator;

    public $selectedTab = 'public';
    public $selectedKudo;
    public $confirmingHideKudos;
    public $confirmingShowKudos;

    public $ShowProductTour = true;

    protected $queryString = [
        'selectedTab' => ['as' => 'tab', 'except' => 'public'],
    ];

    protected $listeners = [
        'refresh-kudos'  => 'refresh',
        'hideKudosModal' => 'openHideKudosModal',
        'showKudosModal' => 'openShowKudosModal',
    ];

    public function mount()
    {
        $this->selectedTab = request('tab', 'public');

        if (
            auth()->user()->productTour &&
            ! auth()->user()->productTour->visited_kudos_feed
        ) {
            auth()->user()->productTour->visited_kudos_feed = 1;
            auth()
                ->user()
                ->productTour->save();
        } else {
            $this->ShowProductTour = false;
        }
    }

    public function render()
    {
        return view('livewire.dash-board', ['team_only' => $this->team_only]);
    }

    public function teamButtonClick($team_id)
    {
        if ($team_id) {
            $this->team_only = true;
            $this->current_team = $team_id;
        } else {
            $this->team_only = false;
            $this->current_team = $team_id;
        }

        $this->emit('team-changed', [
            'team_only' => $this->team_only,
            'current_team' => $this->current_team,
        ]);
    }

    public function updatedSearch($newValue)
    {
        if ($this->search) {
            $this->searchResults = auth()
                ->user()
                ->company->users()
                ->active()
                ->where('first_name', 'like', "%$this->search%")
                ->orWhere('last_name', 'like', "$this->search%")
                ->where('id', '!=', auth()->user()->id)
                ->orderBy('name')
                ->take(5)
                ->get();
        } else {
            $this->reset(['is_showing', 'searchResults']);
        }
    }

    public function selectRecipient($user_id)
    {
        if ($user_id) {
            $this->recipient = User::find($user_id);
            $this->is_showing = 'hidden';
            $this->search = $this->recipient->name;
        } else {
            $this->recipient = null;
            $this->is_showing = '';
            $this->search = '';
        }
    }

    public function openHideKudosModal(Point $point)
    {
        $this->selectedKudo = $point;

        $this->confirmingHideKudos = true;
    }

    public function openShowKudosModal(Point $point)
    {
        $this->selectedKudo = $point;

        $this->confirmingShowKudos = true;
    }

    public function hideSelectedKudos()
    {
        $this->selectedKudo->hidden = 1;
        $this->selectedKudo->hidden_by = auth()->id();
        $this->selectedKudo->save();

        $this->selectedKudo = null;
        $this->confirmingHideKudos = false;

        $this->redirectRoute('kudos.feed');
        //        $this->emit('kudos-modified');
    }

    public function makePublicSelectedKudo()
    {
        $this->selectedKudo->hidden = 0;
        $this->selectedKudo->hidden_by = null;
        $this->selectedKudo->save();

        $this->selectedKudo = null;
        $this->confirmingShowKudos = false;

        $this->redirectRoute('kudos.feed');
        //        $this->emit('kudos-modified');
    }
}

//pagination works
// public function render()
//  {

//  		$collection = auth()->user()->grab_company_points()->sortByDesc("created_at");
//  		//make sure public var isnt "points"
//  	 	$perPage = 10;
//       $offset = max(0, ($this->page - 1) * $perPage);
//       $items = $collection->slice($offset, $perPage + 1);
//       $paginator = new Paginator($items, $perPage, $this->page);

//      return view('livewire.dash-board',['points' => $paginator]);
//  }
