<?php

namespace App\Http\Livewire;

use App\Models\Redemption;
use Auth;
use Livewire\Component;

class ManageCustomRewards extends Component
{
    public $reward_string;

    public $rejectionReason;
    /** @var Redemption */
    public $selectedRedemption;
    public $showRejectingModel = false;
    public $showApprovingModel = false;

    public function render()
    {
        return view('livewire.manage-custom-rewards', [
            'redemptions' => auth()->user()->company
                ->redemptions()
                ->pending()
                ->latest()
                ->get(),
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
    }

    public function mark()
    {
        $rs = $this->reward_string;

        $r = Auth::user()
            ->company->redemptions()
            ->where('redemption_code', $rs)
            ->first();
        if ($rs == null) {
            $this->emit('null');
        } elseif (! $r) {
            $this->emit('not_found');
        } else {
            if ($r->is_rejected == 1 || $r->marked_as_unable_to_furfill == 1) {
                $this->emit('denied');
            } elseif ($r->is_pending == 1) {
                $this->emit('pending');
            } else {
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
        }
    }

    public function approvingRewardRequest($redemptionId)
    {
        $this->selectedRedemption = Redemption::find($redemptionId);
        $this->showApprovingModel = true;
    }

    public function approveRewardRequest()
    {
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

        $this->redirectRoute('rewards.company', [
            'currency' => auth()->user()->currency,
        ]);
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

    public function resetApprovingModel()
    {
        $this->reset('showApprovingModel', 'selectedRedemption');
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

        $this->redirectRoute('rewards.company', [
            'currency' => auth()->user()->currency,
        ]);
    }
}
