<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ManageCompany extends Component
{
    public $viewMoreAdvancedSettings = false;

    public $company;

    public $user;

    public function mount()
    {
        $this->user = auth()->user();

        $this->company = $this->user->company;
    }

    public function render()
    {
        return view('livewire.manage-company');
    }
}
