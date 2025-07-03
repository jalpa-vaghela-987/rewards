<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class CustomizeNameOfKudos extends Component
{
    public $customized_name_of_kudos;

    public function mount()
    {
        $company = auth()->user()->company;

        $this->customized_name_of_kudos = $company->customized_name_of_kudos;
    }

    public function render()
    {
        return view('livewire.customize-name-of-kudos');
    }

    public function updateCustomizedNameOfKudos()
    {
        $validated = $this->validate(
            [
                'customized_name_of_kudos' => [
                    'required',
                    'regex:/^[a-zA-Z0-9][a-zA-Z0-9 ]+$/u',
                    'min:1',
                    'max:10',
                ],
            ],
            [],
            [
                'customized_name_of_kudos' => 'Customize name of '.getReplacedWordOfKudos(),
            ]
        );

        $company = auth()->user()->company;
        $company->customized_name_of_kudos =
            $validated['customized_name_of_kudos'];
        $saved = $company->save();

        if ($saved) {
            Cache::forget('customized_name_of_kudos_'.$company->id);

            $this->emit('saved');
            $this->emit('refresh-navigation-menu');
        }
    }
}
