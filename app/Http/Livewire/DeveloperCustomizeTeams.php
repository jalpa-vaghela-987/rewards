<?php

namespace App\Http\Livewire;

use App\Models\Company;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Actions\ValidateTeamDeletion;
use Laravel\Jetstream\Contracts\DeletesTeams;
use Livewire\Component;

class DeveloperCustomizeTeams extends Component
{
    public $company;
    public $company_search;
    public $companies = [];
    public $is_company_showing = '';

    public $recipient;
    public $recipient_search;
    public $recipients = [];
    public $is_recipient_showing = '';

    /**
     * @var Team
     */
    public $team;
    public $team_search;
    public $teams = [];
    public $is_team_showing = '';

    public function render()
    {
        return view('livewire.developer-customize-teams');
    }

    //    public function updatedTeamSearch()
    //    {
    //        if ($this->team_search && $this->company) {
    //            $this->teams = $this->company
    //                ->teams()
    //                ->where('teams.name', 'like', "$this->team_search%")
    //                ->get();
    //
    //            $this->is_team_showing = '';
    //        } else {
    //            $this->reset(['teams', 'team']);
    //        }
    //    }

    public function updatedRecipientSearch()
    {
        if ($this->recipient_search && $this->company) {
            $this->recipients = User::where(
                'name',
                'like',
                "$this->recipient_search%"
            )
                ->where('active', 1)
                ->where('company_id', $this->company->id)
                ->where('id', '!=', auth()->user()->id)
                ->orderBy('name')
                ->take(5)
                ->get();

            $this->is_recipient_showing = '';
        } else {
            $this->reset(['recipients', 'recipient']);
        }
    }

    public function updatedCompanySearch()
    {
        if ($this->company_search && ! empty($this->company_search)) {
            $this->companies = Company::where(
                'name',
                'like',
                "$this->company_search%"
            )
                ->where('active', 1)
                ->orderBy('name')
                ->take(5)
                ->get();

            $this->is_company_showing = '';
        } else {
            $this->reset(['companies', 'company']);
        }
    }

    public function selectCompany($company_id)
    {
        if ($company_id) {
            $this->company = Company::find($company_id);
            $this->is_company_showing = 'hidden';
            $this->company_search = $this->company->name;
        }
    }

    public function selectRecipient($user_id)
    {
        if ($user_id) {
            $this->recipient = User::find($user_id);
            $this->is_recipient_showing = 'hidden';
            $this->recipient_search = $this->recipient->name;
            $this->teams = $this->recipient->teams()->get();
        }
    }

    public function selectTeam($team_id)
    {
        if ($team_id) {
            $this->team = Team::find($team_id);
            $this->is_team_showing = 'hidden';
            $this->team_search = $this->team->name;
        }
    }

    public function deleteTeam(
        ValidateTeamDeletion $validator,
        DeletesTeams $deleter
    ) {
        $validator->validate(Auth::user(), $this->team);

        if (
            \auth()
                ->user()
                ->teams()
                ->count() > 1
        ) {
            $deleter->delete($this->team);

            $this->redirectRoute('kudos.feed', ['team-removed' => 1]);
        } else {
            $this->dispatchBrowserEvent('notify', [
                'message' => 'Cannot delete remaining team.',
                'style' => 'danger',
            ]);
        }
    }
}
