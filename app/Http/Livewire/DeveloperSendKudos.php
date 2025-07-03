<?php

namespace App\Http\Livewire;

use App\Models\Company;
use App\Models\User;
use Livewire\Component;

class DeveloperSendKudos extends Component
{
    public $company;
    public $company_search;
    public $companies = [];
    public $is_company_showing = '';

    public $recipient;
    public $recipient_search;
    public $recipients = [];
    public $is_recipient_showing = '';

    public function render()
    {
        return view('livewire.developer-send-kudos');
    }

    public function updatedRecipientSearch()
    {
        if ($this->recipient_search && $this->company) {
            $this->recipients = User::where(
                'name',
                'like',
                "$this->recipient_search%"
            )
                ->where('active', 1)
                ->where('company_id', $this->company->id)
                ->where('id', '!=', auth()->user()->id)
                ->orderBy('name')
                ->take(5)
                ->get();

            $this->is_recipient_showing = '';
        } else {
            $this->reset(['recipients', 'recipient']);
        }
    }

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

    public function selectRecipient($user_id)
    {
        if ($user_id) {
            $this->recipient = User::find($user_id);
            $this->is_recipient_showing = 'hidden';
            $this->recipient_search = $this->recipient->name;
        }
    }
}
