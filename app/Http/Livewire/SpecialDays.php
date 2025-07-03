<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class SpecialDays extends Component
{
    public $search;

    public $sortField = 'name';
    public $sortDirection = 'asc';

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('name', 'like', "%$this->search%")
                        ->orWhere('email', 'like', "%$this->search%")
                        ->orWhere('birthday', 'like', "%$this->search%")
                        ->orWhere('anniversary', 'like', "%$this->search%");
                });
            })
            ->when($this->sortField, function ($q) {
                $q->orderBy($this->sortField, $this->sortDirection);
            })
            ->paginate();

        return view('livewire.special-days', compact('users'));
    }

    public function sortBy($field)
    {
        $this->sortDirection =
            $this->sortField === $field
                ? ($this->sortDirection === 'asc'
                    ? 'desc'
                    : 'asc')
                : 'asc';

        $this->sortField = $field;
    }
}
