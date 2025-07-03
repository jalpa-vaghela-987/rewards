<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ConversionRate extends Component
{
    public $conversionRate;

    public $reward_currency;
    public $base_currency;
    public $base_fx;

    public function render()
    {
        return view('livewire.conversion-rate');
    }

    public function mount()
    {
        $this->reward_currency = $this->conversionRate->reward_currency;
        $this->base_currency = $this->conversionRate->base_currency;
        $this->base_fx = $this->conversionRate->base_fx;
    }

    public function updateConversionRate()
    {
        $validated = $this->validate([
            'base_fx' => 'required|numeric|min:0|max:50000',
        ]);

        \App\Models\ConversionRate::reward($this->reward_currency)
            ->base($this->base_currency)
            ->update([
                'base_fx' => $validated['base_fx'],
            ]);

        $this->emit('saved');
    }
}
