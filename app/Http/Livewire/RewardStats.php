<?php

namespace App\Http\Livewire;

use App\Models\Reward;
use Livewire\Component;
use Livewire\WithPagination;

class RewardStats extends Component
{
    use WithPagination;

    public $search;
    public $sortColumn;
    public $sortDirection;

    public function render()
    {
        return view('livewire.reward-stats', [
            'rewards' => $this->fetchRewards(),
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

        return $this->fetchRewards();
    }

    public function fetchRewards()
    {
        return Reward::forCompany()
            //            ->isCustom()
            ->when($this->search, function ($q) {
                $q->where('title', 'like', "$this->search%");
            })
            ->with('recent_redemption', 'recent_redemption.user')
            ->when($this->sortColumn && $this->sortDirection, function ($q) {
                $q->orderBy($this->sortColumn, $this->sortDirection);
            })
            ->paginate();
    }
}
