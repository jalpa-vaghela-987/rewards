<?php

namespace App\Http\Livewire;

use Livewire\Component;

class WalletWelcome extends Component
{
    public $ShowProductTour = true;

    public function mount()
    {
        if (
            auth()->user()->productTour &&
            ! auth()->user()->productTour->visited_wallet
        ) {
            auth()->user()->productTour->visited_wallet = 1;
            auth()
                ->user()
                ->productTour->save();
        } else {
            $this->ShowProductTour = false;
        }
    }

    public function render()
    {
        return view('livewire.wallet-welcome');
    }
}
