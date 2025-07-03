<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class KudoActivity extends Component
{
    use WithPagination;

    public $company = false;

    public function render()
    {
        $companies = $this->company
            ->transactions()
            ->orderBy('created_at', 'desc')
            ->distinct()
            ->paginate(20);

        return view('livewire.kudo-activity', ['companies' => $companies]);
    }
}
