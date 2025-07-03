<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class TeamMemberHasSpecialDayReminder extends Notification implements
    ShouldQueue
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
        return [
            'obj_id' => $this->user->id,
            'tagline' => 'Reminder: '.
                $this->user->name.
                ' has a '.
                $this->specialDay.
                ' Tomorrow!',
            'link' => route('card.create', ['user' => $this->user->id]),
            'type' => ucfirst($this->specialDay),
        ];
    }
}
