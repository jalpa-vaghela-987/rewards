<?php

namespace App\Http\Livewire;

use App\Jobs\RemoveOldMedia;
use App\Models\Card;
use App\Models\CardElement;
use App\Models\Gif;
use App\Models\User;
use App\Notifications\GroupCardPublished;
use App\Notifications\RemindToContributeInGroupCard;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Livewire\WithFileUploads;

class BuildCard extends Component
{
    use WithFileUploads;

    public $card;
    public $text = '';
    public $cardElement;
    public $media;
    public $mediaType;

    //things for gif search below
    public $hide_media = false;
    public $hide_gifs = true;
    public $gifs;
    public $search;
    public $gif;
    public $next = 0;
    public $shouldUpdate;
    public $last_search;

    public $confirmingNotifyPeople;
    public $confirmingSendNotifyPeople = false;
    public $media_preview;
    public $media_processed = false;
    public $media_processing = false;

    //vimeo variables
    public $size;
    public $upload_link;
    public $video_id;

    protected $listeners = [
        'textEdit' => 'textEdit',
        //        'mediaUpload'   => 'uploadCardMedia',
        'load-more' => 'loadMoreGif',
    ];

    public function mount()
    {
        $this->hasCardElement();
        $this->gif = new Gif();
        $this->gifs = collect([]);
    }

    public function hasCardElement()
    {
        $u = auth()->user();
        $users = $this->card->users()->get();

        if (! $users->contains($u) && $this->card->creator_id !== auth()->id()) {
            dump('user not allowed to contribute to this card.');
        }

        // first checks if the user is on the team/users list
        // otherwise checks if they made an element already
        if (
            $this->card
                ->card_elements()
                ->where('user_id', $u->id)
                ->exists()
        ) {
            // this person already made a card element
            $ce = $this->card
                ->card_elements()
                ->where('user_id', $u->id)
                ->first();
            $this->cardElement = $ce;
            $this->video_id = $ce->media_path;
            $this->media_processed = $ce->media_processed;
            $this->text = html_entity_decode(
                htmlspecialchars_decode($this->cardElement->text)
            );
        } else {
            // this person needs to make a new one.
            $ce = new CardElement();
            $ce->user()->associate($u);
            $ce->receiver()->associate($this->card->receiver);
            $ce->card()->associate($this->card);
            if ($this->card->team) {
                $ce->team()->associate($this->card->team);
            }
            $ce->save();
            $this->media_processed = true;
            $this->cardElement = $ce;
        }

        $this->mediaType = data_get($this->cardElement, 'media_type', 'image');
    }

    public function publishCardElement()
    {
        $this->cardElement->active = 1;
        $this->cardElement->save();

        if ($this->media) {
            $this->uploadCardMedia();
        }

        if (auth()->id() !== $this->card->creator_id) {
            $this->card->creator->notify(
                new GroupCardPublished(auth()->user(), $this->card)
            );
        }
    }

    public function uploadCardMedia()
    {
        $this->resetErrorBag();

        // $this->validate([
        //     'media' => 'mimes:jpeg,jpg,png,gif,svg|max:1024',
        // ]);

        if (! isset($this->media)) {
            return;
        }

        $this->hide_media = false;

        if (is_array($this->media)) {
            $this->media = $this->media[0];
        }

        $mimeType = $this->media->getMimeType();
        $mediaType = explode('/', $mimeType)[0];

        if ($mediaType !== 'video') {
            dispatch(new RemoveOldMedia($this->cardElement->media_path));

            info('calling too');
            $path = $this->media->storePublicly('/card-media', 's3');
            $url = 'https://perksweet-uploads.s3.amazonaws.com/'.$path;
            $this->cardElement->media_path = $url;
            $this->cardElement->media_type = $mediaType;
            $this->cardElement->save();
        }
    }

    public function unPublishCardElement()
    {
        $this->cardElement->active = 0;
        $this->cardElement->save();
        $this->render();
    }

    public function render()
    {
        if ($this->cardElement) {
            $this->update();
        }

        return view('livewire.build-card');
    }

    public function update()
    {
        $this->cardElement->text = htmlentities(htmlspecialchars($this->text));
        $this->cardElement->save();
    }

    //    public function updatedMedia()
    //    {
    //        if (isset($this->media)) {
    //            $this->uploadCardMedia();
    //        }
    //    }

    ////////////////// gif functions

    public function updatedSearch()
    {
        $this->hide_gifs = false;
        $this->hide_media = true;

        if (! $this->search) {
            $this->gifs = collect([]);
            $this->hide_gifs = true;
            $this->hide_media = false;
            $this->dispatchBrowserEvent(
                'load-vimeo-video-'.$this->cardElement->id
            );

            return;
        }
        if ($this->search === $this->last_search) {
            return;
        }
        $temp = $this->gif->search_x($this->search, 1);
        $this->gifs = $temp[0];
        $this->next = $temp[1];
        $this->last_search = $this->search;
        $this->dispatchBrowserEvent('gif-hide');
    }

    public function loadMoreGif()
    {
        if (! $this->search) {
            return;
        }
        $temp = $this->gif->search_x($this->search, 1, $this->next);
        $this->gifs = $this->gifs->merge($temp[0]);
        $this->next = $temp[1];
        $this->shouldUpdate = 0;
    }

    public function selectGif($url)
    {
        $this->removeMedia();

        $this->cardElement->media_path = $url;
        $this->cardElement->media_type = 'image';
        $this->cardElement->save();
        $this->hide_media = false;
        $this->hide_gifs = true;
    }

    public function removeMedia()
    {
        $path = $this->cardElement->media_path;

        $this->cardElement->media_path = null;
        $this->cardElement->media_type = null;
        $this->cardElement->save();
        $this->hide_media = true;
        $this->video_id = null;

        $this->reset('media_preview');

        dispatch(new RemoveOldMedia($path));
    }

    // vimeo api calls
    public function createVideoFile($size)
    {
        $this->size = $size;

        $response = Http::withHeaders([
            'Authorization' => 'bearer '.env('VIMEO_ACCESS_TOKEN'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/vnd.vimeo.*+json;version=3.4',
        ])->post('https://api.vimeo.com/me/videos', [
            'upload' => [
                'approach' => 'tus',
                'size' => $this->size, //should be in bytes
            ],
        ]);

        if ($response->successful()) {
            $this->video_id = trim(
                str_replace('videos', '', data_get($response, 'uri')),
                '/'
            );
            $this->upload_link = data_get($response, 'upload.upload_link');

            return $this->upload_link;
        }
    }

    public function updateCardVideoUrl(CardElement $cardElement, $url)
    {
        dispatch(new RemoveOldMedia($cardElement->media_path));

        $cardElement->media_type = 'video';
        $cardElement->media_path = $url;
        $this->mediaType = 'video';

        $cardElement->save();

        $this->dispatchBrowserEvent('video-uploaded-'.$this->cardElement->id);
    }

    public function isMediaProcessed()
    {
        $status = $this->cardElement->media_processed;

        if ($status) {
            $this->hide_media = false;
            $this->media_processed = true;
            if ($this->mediaType == 'video') {
                $this->media_processing = false;
            }

            $this->dispatchBrowserEvent(
                'load-vimeo-video-'.$this->cardElement->id,
                $status
            );
        } else {
            $this->media_processed = false;
            if ($this->mediaType == 'video') {
                $this->media_processing = true;
            }
        }

        return $status;
    }

    public function confirmingSendNotifyPeople()
    {
        $this->confirmingSendNotifyPeople = true;
    }

    public function remindNonContributedUsers()
    {
        $userIds = $this->card->active_users()->pluck('users.id')->toArray();
        $contributorIds = $this->card->card_elements->pluck('user_id')->toArray();
        $toBeNotifiedUserIds = array_unique(array_diff($userIds, $contributorIds));
        $users = User::whereIn('id', $toBeNotifiedUserIds)->where('id', '!=', $this->card->creator_id)->get();

        if (count($users)) {
            Notification::send($users, new RemindToContributeInGroupCard($this->card));

            $this->dispatchBrowserEvent('notify', ['message' => 'Reminder Sent.']);
        } else {
            $this->dispatchBrowserEvent('notify', ['message' => 'No Users To Remind.', 'style' => 'danger']);
        }
        $this->reset(['confirmingSendNotifyPeople']);
    }
}
