<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class CardPhotoUpload extends Component
{
    /// NOTUSED!!!!!
    use WithFileUploads;

    public $photo;

    public function render()
    {
        return view('livewire.card-photo-upload');
    }

    public function uploadCardPhoto()
    {
        $this->resetErrorBag();
        dump($this->photo->store('photos'));
        // $this->cardElement->media_path = $this->photo;
        // $this->cardElement->save();
    }

    /*
     * Delete user's profile photo.
     *
     * @return void
     */
}
