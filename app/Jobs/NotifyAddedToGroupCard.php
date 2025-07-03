<?php

namespace App\Jobs;

use App\Notifications\InvitedToGroupCard;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyAddedToGroupCard implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $card;
    public $user;

    public function __construct($user, $card)
    {
        $this->user = $user;
        $this->card = $card;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->user->notify(new InvitedToGroupCard($this->card));

        $this->user->cards()->updateExistingPivot($this->card->id, ['notified' => 1]);
    }
}
