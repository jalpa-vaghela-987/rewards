<?php

namespace App\Http\Livewire;

use App\Notifications\VerifyEmail;
use Livewire\Component;

class VerifyMailBanner extends Component
{
    public function render()
    {
        return view('livewire.verify-mail-banner');
    }

    public function sendVerificationMail()
    {
        $user = auth()->user();

        $user->notify(new VerifyEmail());

        $this->dispatchBrowserEvent('notify', [
            'message' => 'Verification mail sent to your email.',
        ]);
    }
}
