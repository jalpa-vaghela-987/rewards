<?php

namespace App\Http\Livewire;

use App\Models\Gif;
use Livewire\Component;

class GifKeyboard extends Component
{
    public $gifs;
    public $search;
    public $gif;
    public $next = 0;
    public $shouldUpdate;
    public $last_search;
    protected $listeners = [
        'load-more' => 'loadMore',
        'load-less' => 'loadLess',
        'loadLess' => 'loadLess',
    ];

    public function mount($search = '')
    {
        $this->gif = new Gif();
        $this->search = $search;
        $this->gifs = collect([]);
        $this->shouldUpdate = 1;
        //$this->gifs = $this->gif->search('kitten');
    }

    public function render()
    {
        if ($this->shouldUpdate) {
            $this->update();
        }
        $this->shouldUpdate = 1;

        return view('livewire.gif-keyboard');
    }

    public function update()
    {
        if (! $this->search) {
            return;
        }
        if ($this->search == $this->last_search) {
            return;
        }
        $temp = $this->gif->search_x($this->search, 1);
        $this->gifs = $temp[0];
        $this->next = $temp[1];
        $this->last_search = $this->search;
        $this->dispatchBrowserEvent('gif-hide');
    }

    public function loadMore()
    {
        if (! $this->search) {
            return;
        }
        $temp = $this->gif->search_x($this->search, 1, $this->next);
        $this->gifs = $this->gifs->merge($temp[0]);
        $this->next = $temp[1];
        $this->shouldUpdate = 0;
        //$this->render();
    }

    //$this->last_search = $this->search;
    //$this->emit('gif-load');
    //$this->dispatchBrowserEvent('gif-load');

    //   public function update(){

    // if($this->search){
    //   		$temp = $this->gif->search($this->search,'');
    //   		$this->gifs = collect($temp[0]);
    //   	} else {
    //   		$this->gifs = collect([]);
    //   	}

    //   }

    //     public function loadMore()
    // {
    // 	$temp = $this->gif->search($this->search,$this->next+$this->gif->limit);
    // 	$this->gifs = collect($temp[0])->splice($this->next);
    // 	$this->next = $this->next+$this->gif->limit;
    // 	//dump($this->gifs);
    //     $this->render();
    // }

    //         public function loadLess()
    // {
    // 	$temp = $this->gif->search($this->search,$this->next-$this->gif->limit);
    // 	$this->gifs = collect($temp[0])->splice($this->next);
    // 	$this->next = $this->next-$this->gif->limit;
    // 	//dump($this->next);
    //     $this->render();
    // }
}
