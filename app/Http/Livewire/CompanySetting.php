<?php

namespace App\Http\Livewire;

use App\Models\Company;
use Livewire\Component;

class CompanySetting extends Component
{
    public $search;

    public function render()
    {
        if ($this->search) {
            $company = Company::where('name', 'like', "$this->search%")->get();
        } else {
            $company = Company::all();
        }

        return view('livewire.company-setting', ['company' => $company]);
    }
}
