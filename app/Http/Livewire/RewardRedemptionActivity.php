<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class RewardRedemptionActivity extends Component
{
    use WithPagination;

    public $company = false;

    public function render()
    {
        $company_activity = $this->company
            ->transactions()
            ->orderBy('created_at', 'desc')
            ->where('type', '=', 2)
            ->paginate(20);

        return view('livewire.reward-redemption-activity', [
            'company_activity' => $company_activity,
        ]);
    }
}
