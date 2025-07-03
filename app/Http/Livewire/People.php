<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class People extends Component
{
    public $users;
    public $teams;
    public $upcomingSpecialDays;
    public $upcomingAnniversaries;

    public function render()
    {
        return view('livewire.people');
    }

    public function mount()
    {
        $company = auth()->user()->company;

        $this->users = $company
            ->users()
            ->where('active', 1)
            ->orderBy('name')
            ->get();
        $this->teams = $company
            ->teams()
            ->orderBy('name')
            ->get();

        $this->upcomingSpecialDays = $this->birthdayQuery()
            ->union($this->anniversaryQuery())
            ->orderByRaw(
                'case when current_special_day >= CURRENT_DATE THEN current_special_day ELSE next_special_day END'
            )
            ->get();
    }

    public function birthdayQuery($selectedUserIds = [])
    {
        return User::query()
            ->where('company_id', auth()->user()->company_id)
            ->when(count($selectedUserIds), function ($q) use (
                $selectedUserIds
            ) {
                $q->whereIn('id', $selectedUserIds);
            })
            ->where('active', 1)
            ->whereNotNull('birthday')->selectRaw("
                id, name, email, position,profile_photo_path, birthday as special_day_at, 'birthday' as special_day,
                (birthday + INTERVAL (YEAR(CURRENT_DATE) - YEAR(birthday)) YEAR) as current_special_day,
                (birthday + INTERVAL (YEAR(CURRENT_DATE) - YEAR(birthday)) + 1 YEAR) as next_special_day
            ");
    }

    public function anniversaryQuery($selectedUserIds = [])
    {
        return User::query()
            ->where('company_id', auth()->user()->company_id)
            ->when(count($selectedUserIds), function ($q) use (
                $selectedUserIds
            ) {
                $q->whereIn('id', $selectedUserIds);
            })
            ->where('active', 1)
            ->whereNotNull('anniversary')->selectRaw("
                id, name, email, position,profile_photo_path, anniversary as special_day_at, 'anniversary' as special_day,
                (anniversary + INTERVAL (YEAR(CURRENT_DATE) - YEAR(anniversary)) YEAR) as current_special_day,
                (anniversary + INTERVAL (YEAR(CURRENT_DATE) - YEAR(anniversary)) + 1 YEAR) as next_special_day
            ");
    }

    public function getUpcomingSpecialDaysUsersForTeam($team)
    {
        return $this->birthdayQuery($team->users()->pluck('user_id'))
            ->union($this->anniversaryQuery($team->users()->pluck('user_id')))
            ->orderByRaw(
                'case when current_special_day >= CURRENT_DATE THEN current_special_day ELSE next_special_day END'
            )
            ->get();
    }
}
