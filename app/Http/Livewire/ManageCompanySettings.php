<?php

namespace App\Http\Livewire;

use App\Models\Company;
use Livewire\Component;

class ManageCompanySettings extends Component
{
    public $company;
    public $company_search;
    public $companies = [];
    public $is_company_showing = '';

    public function updatedCompanySearch()
    {
        if ($this->company_search && ! empty($this->company_search)) {
            $this->companies = Company::where(
                'name',
                'like',
                "$this->company_search%"
            )
                ->where('active', 1)
                ->orderBy('name')
                ->take(5)
                ->get();

            $this->is_company_showing = '';
        } else {
            $this->reset(['companies', 'company']);
        }
    }

    public function selectCompany($company_id)
    {
        if ($company_id) {
            $this->company = Company::find($company_id);
            $this->is_company_showing = 'hidden';
            $this->company_search = $this->company->name;
        }
    }

    public function render()
    {
        return view('livewire.manage-company-settings');
    }
}
