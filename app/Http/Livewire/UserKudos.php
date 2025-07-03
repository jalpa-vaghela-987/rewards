<?php

namespace App\Http\Livewire;

use App\Models\Point;
use Livewire\Component;

class UserKudos extends Component
{
    public $user;
    public $points;

    public function render()
    {
        $this->points = Point::where(function ($q) {
            $q->where('user_id', $this->user->id)->orWhere(
                'from_id',
                $this->user->id
            );
        })->get();

        return view('livewire.user-kudos');
    }
}
