<?php

namespace App\Http\Livewire;

use Auth;
use Livewire\Component;

class SearchDropdown extends Component
{
    public $search;
    public $searchResults = [];
    public $itemCollection = [];

    //public $is_showing= "hidden";

    public function mount()
    {
        $this->itemCollection = Auth::user()
            ->company->users->where('active', 1)
            ->sortBy('name');
    }

    public function render()
    {
        return view('livewire.search-dropdown');
    }

    public function updatedSearch($newValue)
    {
        //$searchResults
        //<option value="{{ url('profile/'.$u->id) }}" >{{$u->name}}</option>
        $search = $this->search;
        $filtered = $this->itemCollection->filter(function ($item) use (
            $search
        ) {
            return stripos($item['name'], $search) !== false;
        });

        $this->searchResults = $filtered;
    }

    //  public function show_search()
    // {
    //     if($this->is_showing == 'hidden') $this->is_showing = "";
    //     else $this->is_showing = "hidden";
    //     $this->emit('change-focus-other-field') //any unique event name you want
    // }
}
