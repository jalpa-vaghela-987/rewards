<?php

namespace App\Http\Livewire;

use Auth;
use Livewire\Component;

class GiveKudosWelcome extends Component
{
    public $ShowProductTour = true;

    public function mount()
    {
        if (Auth::user()->productTour && ! Auth::user()->productTour->visited_kudos_give) {
            Auth::user()->productTour->visited_kudos_give = 1;
            Auth::user()->productTour->save();
        } else {
            $this->ShowProductTour = false;
        }
    }

    public function render()
    {
        return view('livewire.give-kudos-welcome');
    }
}
