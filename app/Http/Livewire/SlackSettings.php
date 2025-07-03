<?php

namespace App\Http\Livewire;

use Auth;
use Livewire\Component;

class SlackSettings extends Component
{
    public $enable_slack;
    public $slack_webhook;

    public function mount()
    {
        $this->enable_slack = Auth::user()->company->enable_slack;
        $this->slack_webhook = Auth::user()->company->slack_webhook;
    }

    public function render()
    {
        return view('livewire.slack-settings');
    }

    public function saveSlackSettings()
    {
        $data = $this->validate(
            [
                'enable_slack' => ['required', 'boolean'],
                'slack_webhook' => [
                    'required_if:enable_slack,true',
                    'nullable',
                    'string',
                    'max:500',
                ],
            ],
            [
                'slack_webhook.*' => 'Please click on "Add to Slack" to enable slack notification.',
            ]
        );

        Auth::user()->company->enable_slack = $data['enable_slack'];
        Auth::user()->company->slack_webhook = $data['slack_webhook'];
        $saved = Auth::user()->company->save();

        if ($saved) {
            $this->emit('saved');
            $this->emit('refresh-navigation-menu');
        }
    }
}
