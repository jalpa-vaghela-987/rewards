<?php

namespace App\Jobs;

use App\Models\KudosRefill;
use App\Models\KudosToGiveTransaction;
use App\Models\User;
use App\Notifications\ReceivedMoreKudosToGive;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ResetKudosToGive implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;
    private $kr;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, KudosRefill $kr)
    {
        $this->user = $user;
        $this->kr = $kr;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->user && $this->user->company && $this->user->company->id != null) {
            $t = new KudosToGiveTransaction;
            $t->user()->associate($this->user);
            $t->kudosRefill()->associate($this->kr);
            $t->type = 1;
            $t->link = '';
            $t->data = '';

            if ($this->user->level == 1 || $this->user->level == '1') {
                $t->amount = $this->kr->level_1_points_to_give;
            }
            if ($this->user->level == 2 || $this->user->level == '2') {
                $t->amount = $this->kr->level_2_points_to_give;
            }
            if ($this->user->level == 3 || $this->user->level == '3') {
                $t->amount = $this->kr->level_3_points_to_give;
            }
            if ($this->user->level == 4 || $this->user->level == '4') {
                $t->amount = $this->kr->level_4_points_to_give;
            }
            if ($this->user->level == 5 || $this->user->level == '5') {
                $t->amount = $this->kr->level_5_points_to_give;
            }
            if (! $t->amount) {
                return;
            }
            $t->note = getReplacedWordOfKudos().' to give refill for '.number_format($t->amount).' on '.Carbon::now()->format('m-d-Y');
            $t->expiration = Carbon::now()->addDays(min($this->kr->kudos_expiration_freq, 30));
            $t->amount_remaining = $t->amount;
            $t->save();

            $this->user->points_to_give += $t->amount;
            $this->user->save();

            $this->user->notify(new ReceivedMoreKudosToGive($t));
        }
    }
}
