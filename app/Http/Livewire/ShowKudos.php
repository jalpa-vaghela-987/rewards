<?php

namespace App\Http\Livewire;

use App\Models\Point;
use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ShowKudos extends Component
{
    public $current_team;
    public $type = 'public';
    public $show_options;
    public $show_edit;
    public $team_only = false;
    public $page = 1;
    public $perPage = 15;

    public $kudosText = '';
    public $selectedKudos;
    public $showKudosUpdateModal = false;

    public $hasMorePages;
    public $points;

    protected $listeners = [
        'load-more'      => 'loadMore',
        'team-changed'   => 'teamChanged',
        'kudos-modified' => 'reRenderKudos',
        'update-kudos'   => 'updateKudos',
    ];

    public function mount($show_options = false, $show_edit = true)
    {
        $this->points = new Collection();
        $this->show_edit = $show_edit;
        $this->show_options = $show_options;
        $this->loadKudos();
    }

    public function loadKudos()
    {
        $kudos = ! $this->team_only
            ? $this->getAllPoints()
            : $this->getTeamPoints();

        $this->points->push(...$kudos);

        $this->hasMorePages = (bool) count($kudos);
    }

    public function getAllPoints()
    {
        $pointQuery = Point::query();

        if ($this->type === 'public') {
            $pointQuery->visible();
        } else {
            $pointQuery->private();
        }

        return $pointQuery
            ->whereIn('user_id', auth()->user()->company->users()->pluck('id')->toArray())
            ->latest()
            ->skip(($this->page - 1) * $this->perPage)
            ->take($this->perPage)
            ->get();
    }

    public function getTeamPoints()
    {
        $team = Team::find($this->current_team);

        $pointQuery = Point::query();

        if ($this->type === 'public') {
            $pointQuery->visible();
        } else {
            $pointQuery->private();
        }

        return $pointQuery->whereIn('user_id', $team->users()->pluck('users.id')->toArray())
            ->latest()
            ->skip(($this->page - 1) * $this->perPage)
            ->take($this->perPage)
            ->get();
    }

    public function render()
    {
        return view('livewire.show-kudos', [
            'showEdit'    => $this->show_edit,
            'showOptions' => $this->show_options,
        ]);
    }

    public function loadMore()
    {
        if ($this->hasMorePages !== null && ! $this->hasMorePages) {
            return;
        }

        $this->page++;

        $this->loadKudos();
    }

    public function teamChanged($params)
    {
        $this->team_only = $params['team_only'];
        $this->current_team = $params['current_team'];
        $this->points = new Collection();
        $this->page = 1;
        $this->loadKudos();
    }

    public function sendCard($userId)
    {
        return response()->redirectToRoute('card.create', ['user' => $userId]);
    }

    public function sendKudos($userId)
    {
        return response()->redirectToRoute('kudos-show', ['user' => $userId]);
    }

    public function showEditKudosModal($point)
    {
        $this->kudosText = $point['message'];
        $this->selectedKudos = $point['id'];
        $this->showKudosUpdateModal = true;
        $this->emit('fill-quill-text', html_entity_decode(htmlspecialchars_decode($this->kudosText)));
    }

    public function updateKudos()
    {
        if (
            $this->selectedKudos &&
            ($point = Point::find($this->selectedKudos))
        ) {
            $point->message = $this->kudosText;
            $point->save();
        }

        $this->resetEditKudosModal();
        $this->dispatchBrowserEvent('notify', [
            'message' => getReplacedWordOfKudos().' Update Successfully.',
        ]);

        $this->emit('refresh-kudos');
    }

    public function resetEditKudosModal()
    {
        $this->kudosText = '';
        $this->selectedKudos = null;
        $this->showKudosUpdateModal = false;

        return redirect(request()->header('Referer'));
    }

    public function updatedKudosText($text)
    {
        $this->kudosText = htmlentities(htmlspecialchars($text));
    }
}
