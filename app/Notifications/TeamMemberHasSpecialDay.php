<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use JamesMills\LaravelTimezone\Facades\Timezone;

class TeamMemberHasSpecialDay extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var string
     */
    private $specialDay;
    /**
     * @var User
     */
    private $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, $specialDay)
    {
        $this->user = $user;
        $this->specialDay = $specialDay;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        if ($this->specialDay == 'Birthday') {
            $date = Timezone::convertToLocal($this->user->birthday, 'F jS');
        } else {
            $date = Timezone::convertToLocal($this->user->anniversary, 'F jS').'('.(\Carbon\Carbon::parse($this->user->anniversary)->diffInYears() + 1 .'Years').')';
        }

        return [
            'obj_id' => $this->user->id,
            'tagline' => 'Its '.$this->user->name.'\'s '.$this->specialDay.' on '.$date,
            'link' => route('profile.user', ['user' => $this->user->id]),
            'type' => ucfirst($this->specialDay),
        ];
    }
}
