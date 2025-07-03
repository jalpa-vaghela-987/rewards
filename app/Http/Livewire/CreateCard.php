<?php

namespace App\Http\Livewire;

use App\Models\Card;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Laravel\Jetstream\RedirectsActions;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateCard extends Component // doubles as "edit card"
{
    use RedirectsActions;
    use WithFileUploads;

    public $search;
    public $searchResults = [];
    public $itemCollection = [];
    public $recipient;
    public $is_showing = '';
    public $backgrounds;
    public $selectedBackground;
    public $selectedTheme;
    public $headline;
    public $state = [];
    public $selectedBackgroundPath;
    public $card;
    public $banner_color = '#F9A8D4';
    public $photo;
    public $starting_count;
    public $custom_theme = 0;
    public $send_at;

    protected $rules = [
        'recipient' => 'required',
        'headline' => 'required|max:100',
        'send_at' => 'nullable|date|after:start_date',
        'selectedBackground' => 'required|integer',
    ];
    protected $listeners = [
        'photoUploaded' => 'uploadCardPhoto',
    ];

    public function mount($card = false)
    {
        if (request()->filled('user')) {
            $this->selectRecipient(request('user'));
        }

        $this->itemCollection = auth()
            ->user()
            ->company->users->where('active', 1)
            ->where('id', '!=', auth()->user()->id)
            ->sortBy('name');

        $this->backgrounds = collect([
            [
                '/card_themes/gift1.jpg',
                'Happy Birthday!',
                '#f9a8d4',
                '/card_themes_min/gift1.jpg',
            ],
            [
                '/card_themes/balloons.jpg',
                'Congratulations!',
                '#60A5FA',
                '/card_themes_min/balloons.jpg',
            ],
            [
                '/card_themes/cookies.jpg',
                'Get well soon.',
                '#92400E',
                '/card_themes_min/cookies.jpg',
            ],
            [
                '/card_themes/blue_gift.jpg',
                'Wishing you the best.',
                '#93C5FD',
                '/card_themes_min/blue_gift.jpg',
            ],
            [
                '/card_themes/cupcake.jpg',
                'Thank you!',
                '#F472B6',
                '/card_themes_min/cupcake.jpg',
            ],
            [
                '/card_themes/fireworks.jpg',
                'What an achievement!',
                '#DC2626',
                '/card_themes_min/fireworks.jpg',
            ],
            [
                '/card_themes/christmas.jpg',
                'Happy Holidays!',
                '#DC2626',
                '/card_themes_min/christmas.jpg',
            ],
            [
                '/card_themes/bear.jpg',
                'Welcome, little one!',
                '#f9a8d4',
                '/card_themes_min/bear.jpg',
            ],
            [
                '/card_themes/stars.jpg',
                'You\'re a star!',
                '#F9FAFB',
                '/card_themes_min/stars.jpg',
            ],
            [
                '/card_themes/beach.jpg',
                'Enjoy retirement!',
                '#BFDBFE',
                '/card_themes_min/beach.jpg',
            ],
            [
                '/card_themes/paper.jpg',
                'Well deserved!',
                '#f9a8d4',
                '/card_themes_min/paper.jpg',
            ],
            [
                '/card_themes/gift2.jpg',
                'We appreciate you.',
                '#DC2626',
                '/card_themes_min/gift2.jpg',
            ],
            [
                '/card_themes/dad.jpg',
                'Congrats, Dad!',
                '#047857',
                '/card_themes_min/dad.jpg',
            ],
            [
                '/card_themes/fall.jpg',
                'Farewell.',
                '#FBBF24',
                '/card_themes_min/fall.jpg',
            ],
        ]);

        $dt = Carbon::now()
            ->addDays(2)
            ->hour(11)
            ->minute(0)
            ->second(0);
        if ($dt->isWeekend()) {
            $dt->addDays(2);
        }
        $dt = $dt->format("Y-m-d\TH:i");
        //$this->send_at = $dt; // this would autoset the date field
        if ($card) {
            if ($this->card) {
                $this->headline = $this->card->headline;
                $this->recipient = $this->card->receiver;
                $this->selectedBackground = $this->card->theme;
                $this->selectedBackgroundPath =
                    $this->card->background_photo_path;
                $this->banner_color = $this->card->banner_color;
                $this->custom_theme = $this->card->custom_theme;
                if ($this->card->custom_theme) {
                    $this->backgrounds->push([
                        $this->card->background_photo_path,
                        $this->card->headline,
                        $this->card->banner_color,
                        $this->getMinBackgroundPath(
                            $this->card->background_photo_path
                        ),
                    ]);
                }
            }
        }

        $this->starting_count = count($this->backgrounds);
    }

    public function render()
    {
        return view('livewire.create-card');
    }

    public function updatedSearch($newValue)
    {
        $search = $this->search;
        $filtered = $this->itemCollection->filter(function ($item) use (
            $search
        ) {
            return stripos($item['name'], $search) !== false;
        });

        $this->searchResults = $filtered;
        $this->is_showing = '';
    }

    public function selectRecipient($user_id)
    {
        if ($user_id) {
            $this->recipient = User::find($user_id);
            $this->is_showing = 'hidden';
            $this->search = $this->recipient->name;
        }
    }

    public function selectBackground($bg_id)
    {
        $this->selectedTheme = $bg_id;
        $this->selectedBackground = $bg_id;
        $this->banner_color = $this->backgrounds[$bg_id - 1][2];
        // $is_stock = false;
        // for($i = 0;$i<count($this->backgrounds);$i++){
        //     if($this->headline == $this->backgrounds[$i][1]) $is_stock = true;
        // }
        $headlines = $this->backgrounds->map(function ($item, $key) {
            return $item[1];
        });

        if (! $this->headline) {
            $this->headline = $this->backgrounds[$bg_id - 1][1];
        }
    }

    public function createCard()
    {
        $this->validate();
        if ($this->selectedBackgroundPath) {
            $this->selectedBackgroundPath =
                $this->backgrounds[$this->selectedBackground - 1][0];
        } else {
            $this->selectedBackgroundPath =
                $this->backgrounds[$this->selectedBackground - 1][0];
        }
        if (
            $this->recipient &&
            $this->recipient->name &&
            $this->recipient->email &&
            $this->selectedBackgroundPath
        ) {
            if ($this->card) {
                $c = $this->card;
            } else {
                $c = new Card();
            }
            $c = $this->makeCard($c);

            return redirect()->route('card.people', ['card' => $c->id]);
        }
    }

    public function makeCard($c)
    {
        $c->creator()->associate(Auth::user());
        $c->receiver()->associate($this->recipient);
        if (Auth::user()->hasTeams()) {
            $c->team()->associate(Auth::user()->currentTeam);
        }
        $c->headline = $this->headline;
        $c->send_at = $this->send_at;
        $c->display_name = $this->recipient->name;
        $c->email = $this->recipient->email;
        $c->card_type = 'original';
        $c->background_photo_path = $this->selectedBackgroundPath;
        $c->theme = intval($this->selectedBackground);
        $c->banner_color = $this->banner_color;
        $c->custom_theme = $this->custom_theme;
        $c->hash = sha1(time());
        $c->save();

        return $c;
    }

    public function updatedPhoto()
    {
        $this->resetErrorBag();
        //dump($this->photo);
        if (! isset($this->photo)) {
            return;
        }
        $path = $this->photo->storePublicly('/card-media', 's3');
        $url = 'https://perksweet-uploads.s3.amazonaws.com/'.$path;
        $this->selectedBackgroundPath = $url;
        $this->backgrounds->push([
            $this->selectedBackgroundPath,
            $this->headline,
            $this->banner_color,
            $this->getMinBackgroundPath($this->selectedBackgroundPath),
        ]);
        $this->selectedBackground = count($this->backgrounds);
        $this->custom_theme = 1;
    }

    public function getMinBackgroundPath($path)
    {
        return str_replace('card_themes', 'card_themes_min', $path);
    }

    public function updatedBannerColor()
    {
        $this->backgrounds = $this->backgrounds->map(function ($item, $key) {
            if ($key == $this->selectedBackground - 1) {
                $item[2] = $this->banner_color;
            }

            return $item;
        });
    }

    public function viewCard()
    {
        $this->validate();
        if (! $this->selectedBackgroundPath) {
            $this->selectedBackgroundPath =
                $this->backgrounds[$this->selectedBackground - 1][0];
        }
        if (
            $this->recipient &&
            $this->recipient->name &&
            $this->recipient->email &&
            $this->selectedBackgroundPath
        ) {
            if ($this->card) {
                $c = $this->card;
            } else {
                $c = new Card();
            }
            $c = $this->makeCard($c);

            return redirect()->route('card.build', $c->id);
        }
    }
}
