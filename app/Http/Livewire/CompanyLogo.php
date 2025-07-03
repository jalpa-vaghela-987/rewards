<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CompanyLogo extends Component
{
    public $logo = '';

    protected $listeners = [
        'company_logo_updated' => 'updateLogo',
    ];

    public function updateLogo($params)
    {
        $this->logo = $params['logo'];

        $this->render();
    }

    public function render()
    {
        $this->logo = auth()->user()->company->logo_path;

        return view('livewire.company-logo', [
            'company_name' => auth()->user()->company->name,
        ]);
    }
}
