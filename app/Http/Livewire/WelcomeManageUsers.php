<?php

namespace App\Http\Livewire;

use Livewire\Component;

class WelcomeManageUsers extends Component
{
    public $ShowProductTour = true;

    public function mount()
    {
        if (
            auth()->user()->productTour &&
            ! auth()->user()->productTour->visited_manage_users
        ) {
            auth()->user()->productTour->visited_manage_users = 1;
            auth()
                ->user()
                ->productTour->save();
        } else {
            $this->ShowProductTour = false;
        }
    }

    public function render()
    {
        return view('livewire.welcome-manage-users');
    }
}
