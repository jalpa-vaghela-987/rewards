<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class WhitelabelCompany extends Component
{
    use WithFileUploads;

    public $photo;
    public $company_name;
    public $whitelabel_enabled = false;
    public $whitelabel_company;

    public $uploaded_logo;

    public function render()
    {
        $this->uploaded_logo = data_get($this->whitelabel_company, 'logo_path');

        return view('livewire.whitelabel-company');
    }

    public function mount($company = false)
    {
        if ($company) {
            $this->whitelabel_company = $company->whitelabel_company;
        }

        $this->company_name = data_get($this->whitelabel_company, 'name');
        $this->photo = data_get($this->whitelabel_company, 'logo_path');
        $this->whitelabel_enabled = (bool) data_get(
            $this->whitelabel_company,
            'whitelabel_enabled'
        );
    }

    public function submitCompany()
    {
        $this->validate(
            [
                'photo' => ['required'],
                'company_name' => [
                    'required',
                    'max:120',
                    'regex:/^[a-zA-Z0-9][a-zA-Z0-9 ]+$/u',
                ],
                'whitelabel_enabled' => ['required', 'boolean'],
            ],
            [],
            [
                'photo' => 'Logo',
            ]
        );

        if ($this->photo != null && ! is_string($this->photo)) {
            $path = $this->photo->storePublicly(
                'whitelabel_company_photos',
                's3'
            );
            if ($path != null) {
                $path = 'https://perksweet-uploads.s3.amazonaws.com/'.$path;
            }
        } else {
            $path = $this->photo;
        }

        if (! $this->whitelabel_company) {
            $this->whitelabel_company = new \App\Models\WhitelabelCompany();
            $this->whitelabel_company->company_id = auth()->user()->company_id;
        }

        $this->whitelabel_company->name = $this->company_name;
        $this->whitelabel_company->logo_path = $path;
        $this->whitelabel_company->whitelabel_enabled =
            $this->whitelabel_enabled;
        $this->whitelabel_company->save();

        $this->emit('saved');

        $this->redirectRoute('manage.company');
    }
}
