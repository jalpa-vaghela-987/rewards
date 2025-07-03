<?php

namespace App\Http\Livewire;

use App\Models\Company;
use App\Models\KudosToGiveTransaction;
use App\Models\User;
use App\Notifications\ReceivedMoreKudosToGive;
use Carbon\Carbon;
use Livewire\Component;

class DeveloperSendKudosToGiveAway extends Component
{
    public $amount;

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
        return view('livewire.developer-send-kudos-to-give-away');
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

    public function sendKudos()
    {
        $this->validate(
            [
                'company' => ['required'],
                'recipient' => ['required'],
                'amount' => ['required', 'gte:100'],
            ],
            [],
            [
                'amount' => 'number of kudos',
            ]
        );

        if (! $this->company) {
            $this->addError('company', 'Selected company does not exists.');
        }

        if (
            ! $this->recipient ||
            ! $this->company
                ->users()
                ->where('id', $this->recipient->id)
                ->exists()
        ) {
            $this->addError('recipient', 'Selected recipient does not exists.');
        }

        if ($this->getErrorBag()->count()) {
            return $this->errorBag;
        }

        $transaction = new KudosToGiveTransaction();
        $transaction->user()->associate($this->recipient);
        $transaction->type = 1;
        $transaction->link = '';
        $transaction->data = '';
        $transaction->amount = $this->amount;
        $transaction->note =
            getReplacedWordOfKudos().
            ' to give refill for '.
            number_format($transaction->amount).
            ' on '.
            Carbon::now()->format('m-d-Y');
        $transaction->expiration = Carbon::now()->addDays(
            $this->company->kudos_expiration_freq
        );
        $transaction->amount_remaining = $transaction->amount;
        $transaction->save();

        $this->recipient->points_to_give += $transaction->amount;
        $this->recipient->save();

        $this->recipient->notify(new ReceivedMoreKudosToGive($transaction));

        $this->emit('saved');

        $this->reset();
    }
}
