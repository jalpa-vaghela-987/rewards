<?php

namespace App\Http\Livewire;

use App\Models\Reward;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateReward extends Component
{
    use WithFileUploads;

    public $title;
    public $description;
    public $use_set_amount = true;
    public $cost;
    public $max_kudos_value;
    public $min_kudos_value;
    public $redemption_instructions;
    public $kudos_conversion_rate = 100;
    public $disabled;
    public $reward = false;
    public $stock_amount;
    public $enable_inventory_tracking;
    public $photo;
    public $currency = 'USD';

    public function render()
    {
        return view('livewire.create-reward');
    }

    //note depreciate variable custom rewards as of 11/26/2021

    public function mount()
    {
        if ($this->reward) {
            $this->title = $this->reward->title;
            $this->description = $this->reward->description;
            $this->use_set_amount = true;
            $this->cost = $this->reward->cost;
            $this->max_kudos_value = $this->reward->max_kudos_value ?? null;
            $this->min_kudos_value = $this->reward->min_kudos_value ?? null;
            $this->redemption_instructions =
                $this->reward->custom_redemption_instructions;
            $this->kudos_conversion_rate =
                $this->reward->kudos_conversion_rate ?? null;
            $this->disabled = $this->reward->disabled;
            $this->stock_amount = $this->reward->stock_amount;
            $this->enable_inventory_tracking =
                $this->reward->enable_inventory_tracking;
            $this->photo = $this->reward->photo_path;
            $this->currency = $this->reward->currency ?? auth()->user()->currency;
        }
    }

    public function updateReward()
    {
        if (! $this->use_set_amount) {
            $this->use_set_amount = false;
        }
        if (! $this->disabled) {
            $this->disabled = false;
        }

        if (! $this->enable_inventory_tracking) {
            $this->enable_inventory_tracking = false;
        }

        $data = $this->validate([
            'title' => 'required|string|min:0|max:100',
            'description' => 'required|string|min:0|max:2000',
            'use_set_amount' => 'required|boolean',
            'disabled' => 'required|boolean',
            'cost' => 'nullable|required_unless:use_set_amount,false|integer|max:100000',
            'max_kudos_value' => 'required_if:use_set_amount,false|nullable|integer|max:100000|gte:min_kudos_value',
            'min_kudos_value' => 'required_if:use_set_amount,false|nullable|integer|max:50000',
            'redemption_instructions' => 'required|string|min:1|max:10000',
            'kudos_conversion_rate' => 'nullable|required_unless:use_set_amount,true|integer|max:10000',
            'stock_amount' => 'nullable|required_unless:enable_inventory_tracking,false|integer|min:0|max:1000',
            'enable_inventory_tracking' => 'required|boolean',
            'photo' => 'nullable',
            'currency' => 'required|string|max:10',
        ]);

        // if ($data['use_set_amount'] && $data['min_kudos_value'] < 1) {
        //     $this->addError(
        //         'min_kudos_value',
        //         'Minimum '.
        //             getReplacedWordOfKudos().
        //             ' value must be greater than or equal to 100'
        //     );
        // }

        // if ($data['use_set_amount'] && $data['max_kudos_value'] < 100) {
        //     $this->addError(
        //         'min_kudos_value',
        //         'Maximum '.
        //             getReplacedWordOfKudos().
        //             ' value must be greater than or equal to 100'
        //     );
        // }

        // if ($data['use_set_amount'] && $data['kudos_conversion_rate'] < 10) {
        //     $this->addError(
        //         'min_kudos_value',
        //         getReplacedWordOfKudos().
        //             ' conversion rate must be greater than or equal to 10'
        //     );
        // }

        if (! $data['use_set_amount'] && $data['cost'] < 1) {
            $this->addError(
                'min_kudos_value',
                'Reward cost must be greater than or equal to 1'
            );
        }

        if (! $this->reward) {
            $r = new Reward();
        } else {
            $r = $this->reward;
        }
        $r->title = $data['title'];
        $r->description = $data['description'];
        $r->use_set_amount = $data['use_set_amount'];
        $r->disabled = $data['disabled'];
        $r->cost = $data['cost'] ?? 0;
        $r->max_kudos_value = $data['max_kudos_value'] ?? 0;
        $r->min_kudos_value = $data['min_kudos_value'] ?? 0;
        $r->max_value =
            ((float) $data['max_kudos_value']) /
                (float) $data['kudos_conversion_rate'] ??
            0;
        $r->min_value =
            ((float) $data['min_kudos_value']) /
                (float) $data['kudos_conversion_rate'] ??
            0;
        $r->custom_redemption_instructions = $data['redemption_instructions'];
        $r->kudos_conversion_rate = $data['kudos_conversion_rate'] ?? 0;
        $r->stock_amount = $data['stock_amount'] ?? 0;
        $r->enable_inventory_tracking = $data['enable_inventory_tracking'];
        $r->type = 'Custom Reward';
        $r->currency = $data['currency'];
        $r->is_custom = 1;

        if (isset($this->photo) && ! is_string($this->photo)) {
            $path = $this->photo->storePublicly('/reward-media', 's3');
            $url = 'https://perksweet-uploads.s3.amazonaws.com/'.$path;
            $r->photo_path = $url;
        }

        if (! $r->creator) {
            $r->creator()->associate(auth()->user());
        }
        $r->company()->associate(auth()->user()->company);

        $r->save();

        if ($this->reward) {
            session()->flash('flash.banner', 'Custom Reward updated.');
        } else {
            session()->flash(
                'flash.banner',
                'Custom Reward Create Successfully. '
            );
        }
        $this->redirectRoute('rewards.company', [
            'currency' => $r->currency != null ? $r->currency : auth()->user()->currency,
        ]);
        //        return redirect('rewards.company',['currency' => auth()->user()->currency]);
    }
}
