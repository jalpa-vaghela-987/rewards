<?php

namespace App\Http\Livewire;

use App\Models\Tango;
use Livewire\Component;

class UpdateTangos extends Component
{
    public $tangos;

    public function mount()
    {
        $this->tangos = Tango::where(
            'currency',
            request('currency', auth()->user()->currency)
        )->get();
    }

    public function render()
    {
        return view('livewire.update-tangos');
    }

    public function toggle_status(Tango $r)
    {
        if ($r->disabled) {
            $r->disabled = 0;
        } else {
            $r->disabled = 1;
        }

        $r->save();
    }
}
