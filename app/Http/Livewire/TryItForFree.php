<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class TryItForFree extends Component
{
    public $email;

    public function render()
    {
        return view('livewire.try-it-for-free');
    }

    public function sendMail()
    {
        try {
            $this->validate(['email' => ['required', 'email']]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('notify', [
                'style' => 'danger',
                'message' => $e->validator->errors()->first('email'),
            ]);

            return '';
        }

        Mail::to(env('SALES_MAIL', 'sales@perksweet.com'))->send(
            new \App\Mail\TryItForFree($this->email)
        );

        $this->reset();

        return redirect()->route('manage.company.create_form');
    }
}
