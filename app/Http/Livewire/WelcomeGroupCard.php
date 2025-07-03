<?php

namespace App\Http\Livewire;

use Livewire\Component;

class WelcomeGroupCard extends Component
{
    public $ShowProductTour = true;

    public function mount()
    {
        if (
            auth()->user()->productTour &&
            ! auth()->user()->productTour->visited_group_cards
        ) {
            auth()->user()->productTour->visited_group_cards = 1;
            auth()
                ->user()
                ->productTour->save();
        } else {
            $this->ShowProductTour = false;
        }
    }

    public function render()
    {
        return view('livewire.welcome-group-card');
    }
}
