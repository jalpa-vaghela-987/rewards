<?php

namespace App\Http\Livewire;

use Auth;
use Livewire\Component;

class ManageConnectSettings extends Component
{
    public $enable_connect;

    public function mount()
    {
        $this->enable_connect = Auth::user()->company->using_connect;
    }

    public function render()
    {
        return view('livewire.manage-connect-settings');
    }

    public function saveConnectSettings()
    {
        $data = $this->validate([
            'enable_connect' => 'required|boolean',
        ]);

        Auth::user()->company->using_connect = $data['enable_connect'];
        $saved = Auth::user()->company->save();

        if ($saved) {
            $this->emit('saved');
            $this->emit('refresh-navigation-menu');
        }
    }
}
