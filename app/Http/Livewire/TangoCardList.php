<?php

namespace App\Http\Livewire;

use App\Models\Reward;
use Livewire\Component;
use Livewire\WithPagination;

class TangoCardList extends Component
{
    use WithPagination;

    public $disabled = false;
    public $currency;

    public function render()
    {
        $rewards = \App\Models\Reward::active()
            ->when(request('currency', auth()->user()->currency), function (
                $q
            ) {
                $q->whereJsonContains('tango_data->items', [
                    'currencyCode' => request(
                        'currency',
                        auth()->user()->currency
                    ),
                ]);
            })
            ->where('disabled', $this->disabled ? 1 : 0)
            ->where('tango_utid', '!=', null)
            ->get();

        return view('livewire.tango-card-list', ['rewards' => $rewards]);
    }

    public function mount()
    {
        $this->currency = request('currency', auth()->user()->currency);
    }

    public function toggleApproval($rewardId)
    {
        $reward = Reward::find($rewardId);

        $reward->toggleApproval();

        $this->dispatchBrowserEvent('notify', [
            'message' => $reward->approval_needed
                ? 'Manual Approval Enabled!'
                : 'Manual Approval Disabled!',
        ]);
    }

    public function toggleDisable($rewardId)
    {
        $reward = Reward::find($rewardId);

        $reward->toggleDisable();
        session()->flash('flash.banner', 'Card Status Updated!');

        $this->redirectRoute('rewards.company', [
            'currency' => $this->currency,
        ]);
    }
}
