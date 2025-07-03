<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class FundingHistory extends Component
{
    use WithPagination;

    public $company = false;

    public function render()
    {
        $funding = $this->company
            ->companyTransactions()
            ->orderBy('created_at', 'desc')
            ->where('active', 1)
            ->paginate(20);

        return view('livewire.funding-history', ['funding' => $funding]);
    }
}
