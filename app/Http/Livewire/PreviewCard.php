<?php

namespace App\Http\Livewire;

use App\Notifications\ReceivedGroupCard;
use App\Notifications\SentGroupCard;
use Illuminate\Support\Str;
use Livewire\Component;

class PreviewCard extends Component
{
    public $card;
    public $confirmingSend = false;

    public function render()
    {
        return view('livewire.preview-card');
    }

    public function sendCard()
    {
        $this->card->sent_to_recipient = 1;
        $this->card->sent_at = now();
        $this->card->token = Str::uuid();
        $this->card->save();
        $this->card->receiver->notify(new ReceivedGroupCard($this->card));

        foreach ($this->card->users as $u) {
            if ($u->id !== $this->card->creator->id) {
                $u->notify(new SentGroupCard($this->card));
            }
        }

        return redirect()->route('card.view', [
            'card' => $this->card->token,
            'sent' => true,
        ]);
    }
}
