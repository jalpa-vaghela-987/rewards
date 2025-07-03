<?php

namespace App\Jobs;

use App\Models\KudosToGiveTransaction;
use App\Notifications\KudosToGiveAboutToExpire as KN;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class KudosToGiveAboutToExpire implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $t;

    public function __construct(KudosToGiveTransaction $t)
    {
        $this->t = $t;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->t->user->notify(new KN($this->t));
    }
}
