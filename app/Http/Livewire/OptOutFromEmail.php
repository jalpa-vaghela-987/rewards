<?php

namespace App\Http\Livewire;

use Laravel\Jetstream\ConfirmsPasswords;
use Livewire\Component;

class OptOutFromEmail extends Component
{
    use ConfirmsPasswords;

    public $enabled;

    public function render()
    {
        $this->enabled = auth()->user()->emails_opt_in;

        return view('livewire.opt-out-from-email');
    }

    public function toggleEmailNotification()
    {
        auth()->user()->emails_opt_in = ! auth()->user()->emails_opt_in;

        auth()
            ->user()
            ->save();

        //after that, put code in all emails to check this flag first. ( send message only -> if this flag is true )
    }
}
