<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MicrosoftTeamsSettings extends Component
{
    public $enable_microsoft_teams;
    public $microsoft_teams_webhook;

    public function mount()
    {
        $this->enable_microsoft_teams = Auth::user()->company->enable_microsoft_teams;
        $this->microsoft_teams_webhook = Auth::user()->company->microsoft_teams_webhook;
    }

    public function saveMicrosoftTeamsSettings()
    {
        $data = $this->validate([
            'enable_microsoft_teams' => ['required', 'boolean'],
            'microsoft_teams_webhook' => [
                'required_if:enable_microsoft_teams,true',
                'nullable',
                'string',
                'max:500',
            ],
        ]);

        $company = Auth::user()->company;

        $company->enable_microsoft_teams = $data['enable_microsoft_teams'];
        $company->microsoft_teams_webhook = $data['microsoft_teams_webhook'];
        $saved = $company->save();

        if ($saved) {
            $this->emit('saved');
            $this->emit('refresh-navigation-menu');
        }
    }

    public function render()
    {
        return view('livewire.microsoft-teams-settings');
    }
}
