<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class UserStats extends Component
{
    use WithPagination;

    public $search;
    public $sortColumn = null;
    public $sortDirection = null;

    public function render()
    {
        return view('livewire.user-stats', [
            'users' => $this->fetchUsers(),
        ]);
    }

    public function sort($column)
    {
        $this->sortDirection =
            $column === $this->sortColumn
                ? ($this->sortDirection === 'asc'
                    ? 'desc'
                    : 'asc')
                : 'asc';
        $this->sortColumn = $column;

        return $this->fetchUsers();
    }

    public function fetchUsers()
    {
        return auth()
            ->user()
            ->company->users()
            ->when($this->search, function ($q) {
                $q->where('first_name', 'like', "$this->search%");
                $q->orWhere('last_name', 'like', "$this->search%");
            })
            ->when($this->sortColumn && $this->sortDirection, function ($q) {
                $q->orderBy($this->sortColumn, $this->sortDirection);
            })
            ->orderby('name')
            ->paginate();
    }
}
