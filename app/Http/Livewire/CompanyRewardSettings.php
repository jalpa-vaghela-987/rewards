<?php

namespace App\Http\Livewire;

use Auth;
use Livewire\Component;

class CompanyRewardSettings extends Component
{
    public $allow_tango_cards;

    public function render()
    {
        return view('livewire.company-reward-settings');
    }

    public function mount()
    {
        $this->allow_tango_cards = Auth::user()->company->allow_tango_cards;
    }

    public function saveCompanyRewardSettings()
    {
        if (! $this->allow_tango_cards) {
            $this->allow_tango_cards = false;
        }

        $data = $this->validate([
            'allow_tango_cards' => 'required|boolean',
        ]);

        $c = Auth::user()->company;

        $c->allow_tango_cards = $data['allow_tango_cards'];
        $saved = $c->save();

        if ($saved) {
            $this->emit('saved');
        }
    }
}
