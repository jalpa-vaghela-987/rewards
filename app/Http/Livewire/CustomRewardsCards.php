<?php

namespace App\Http\Livewire;

use App\Models\Reward;
use Livewire\Component;

class CustomRewardsCards extends Component
{
    public $disabled = false;
    public $selectedCardId;
    public $confirmingCustomRewardDeletion = false;
    public $currency;

    public function render()
    {
        $customCards = [];

        request()->merge(request()->only('currency'));

        if (auth()->user() && ($company = auth()->user()->company)) {
            $customCards = $company
                ->rewards()
                ->where('active', 1)
                ->where('is_custom', 1)
                ->where('disabled', $this->disabled ? 1 : 0)
                ->when($this->currency, function ($q) {
                    $q->where('currency', $this->currency);
                })
                ->orderBy('title')
                ->get();
        }

        return view('livewire.custom-rewards-cards', ['cards' => $customCards]);
    }

    public function mount()
    {
        $this->currency = request('currency', auth()->user()->currency);
    }

    public function confirmingDeleteCustomReward($cardId)
    {
        $this->selectedCardId = $cardId;

        $this->confirmingCustomRewardDeletion = true;
    }

    public function deleteCustomReward()
    {
        if ($this->selectedCardId) {
            $company = auth()->user()->company;

            $company
                ->rewards()
                ->where('id', $this->selectedCardId)
                ->delete();

            $this->reset(['selectedCardId', 'confirmingCustomRewardDeletion']);
            session()->flash(
                'flash.banner',
                'Delete Custom Reward Successfully'
            );

            return response()->redirectToRoute('rewards.company', [
                'currency' => $this->currency,
            ]);
        }
    }

    public function toggleApproval($rewardId)
    {
        $reward = Reward::find($rewardId);

        $reward->toggleApproval();

        //        session()->flash('flash.banner', $reward->approval_needed ? 'Manual Approval Enabled!' : 'Manual Approval Disabled!');
        //
        //        $this->redirectRoute('rewards.company', ['currency' => $this->currency]);

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
