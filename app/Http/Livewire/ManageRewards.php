<?php

namespace App\Http\Livewire;

use App\Models\Redemption;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ManageRewards extends Component
{
    public $reward_string;

    public $rejectionReason;
    /** @var Redemption */
    public $selectedRedemption;
    public $showRejectingModel = false;

    public function render()
    {
        return view('livewire.manage-rewards', [
            'rewards' => auth()
                ->user()
                ->company->redemptions()
                ->with(['user'])
                //->where("is_custom",1)
                ->latest()
                ->paginate(30),
        ]);
    }

    public function toggleReceipt(Redemption $r)
    {
        if (Auth::user()->role !== 1) {
            return;
        }
        if ($r->confirmed_reciept) {
            $r->confirmed_reciept = 0;
        } else {
            $r->confirmed_reciept = 1;
        }
        $r->save();
        $this->redirectRoute('reward-redemption');
    }

    public function mark()
    {
        $rs = $this->reward_string;
        $r = Auth::user()
            ->company->redemptions->where('redemption_code', $rs)
            ->first();
        if (! $r) {
            $this->emit('not_found');

            return;
        }
        if ($r->confirmed_reciept) {
            $this->emit('marked_already');

            return;
        }

        if (isset($r->reward->enable_inventory_tracking)) {
            $r->reward->inventory_confirmed += 1;
            $r->reward->save();
        }
        $r->confirmed_reciept = 1;
        $r->save();
        $this->emit('saved');
    }

    public function approveRewardRequest($redemptionId)
    {
        $this->selectedRedemption = Redemption::find($redemptionId);

        $response = $this->selectedRedemption->process();

        if (is_string($response)) {
            $this->dispatchBrowserEvent('notify', [
                'message' => $response,
                'style' => 'danger',
                'timeout' => 5000,
            ]);
        } else {
            $this->dispatchBrowserEvent('notify', [
                'message' => 'Redemption Request approved successfully.',
            ]);
        }

        $this->redirectRoute('reward-redemption');
    }

    public function rejectingRewardRequest($redemptionId)
    {
        $this->selectedRedemption = Redemption::find($redemptionId);
        $this->showRejectingModel = true;
    }

    public function resetRejectionModel()
    {
        $this->reset('showRejectingModel', 'rejectionReason');
    }

    public function rejectRedemptionRequest()
    {
        $this->validate([
            'rejectionReason' => ['required', 'string', 'min:3', 'max:1000'],
        ]);

        /** @var Redemption $redemption */
        $redemption = $this->selectedRedemption;

        if (! $redemption->is_pending) {
            return $this->addError(
                'rejectionReason',
                'Redemption is already processed!'
            );
        }

        $redemption->rejection_reason = $this->rejectionReason;
        $redemption->save();

        $redemption->cancel();

        $this->redirectRoute('reward-redemption');
    }
}
