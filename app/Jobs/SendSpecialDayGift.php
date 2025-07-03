<?php

namespace App\Jobs;

use App\Models\Point;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\PointReceivedForSpecialDay;
use App\Notifications\TeamMemberHasSpecialDay;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class SendSpecialDayGift implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $special_day;
    public $company;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $specialDay)
    {
        $this->user = $user;
        $this->special_day = $specialDay;
        $this->company = $user->company;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->sendKudos();

        $this->sendNotificationToAllTeamMembers();
    }

    public function sendKudos()
    {
        $amount = $this->getKudosAmount();

        $specialDay = trans('point.'.$this->special_day);

        if ($this->special_day === Point::TYPE_ANNIVERSARY) {
            $specialDay = Carbon::parse($this->user->anniversary)->diffInYears().' Year '.$specialDay;
        }

        $message = trans('point.special-message', [
            'name'        => config('app.name'),
            'special_day' => $specialDay,
        ]);

        $point = $this->givePoints($amount, $message);

        $this->createTransaction($point, $message);
    }

    public function getKudosAmount()
    {
        return data_get($this->company, $this->special_day.'_value', config('company.default_points.'.$this->special_day));
    }

    public function givePoints($amount, $message)
    {
        $point = new Point();
        $point->amount = $amount;
        $point->message = $message;
        $point->type = $this->special_day;

//            $point->giver()->associate($systemUser->id);

        $this->user->points += (int) $amount;
        $this->user->save();

        $point->reciever()->associate($this->user);
        $point->save();

        $this->user->notify(new PointReceivedForSpecialDay($point, $this->special_day));

        return $point;
    }

    public function createTransaction($point, $message)
    {
        $transaction = new Transaction();
        $transaction->user()->associate($this->user);
        $transaction->point()->associate($point);
        $transaction->note = $message;
        $transaction->link = '/received/'.$point->id;
        $transaction->amount = $point->amount;
        $transaction->type = 1;
        $transaction->data = json_encode($point);
        $transaction->save();
    }

    public function sendNotificationToAllTeamMembers()
    {
        $allTeamMembersId = DB::table('team_user')
            ->selectRaw('distinct(user_id)')
            ->where('user_id', '!=', $this->user->id)
            ->whereIn('team_id', $this->user->teams()->select('team_id'))
            ->pluck('user_id');

        $teamMembers = User::active()->whereIn('id', $allTeamMembersId)->cursor();

        foreach ($teamMembers as $teamMember) {
            $teamMember->notify(
                new TeamMemberHasSpecialDay($this->user, trans('point.'.$this->special_day))
            );
        }
    }
}
