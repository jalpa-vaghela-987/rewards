<?php

namespace App\Notifications;

use App\Models\KudosToGiveTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class KudosToGiveAboutToExpire extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $t;

    public function __construct(KudosToGiveTransaction $t)
    {
        $this->t = $t;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        //return ['database']; //avoiding mail for testing for now

        if (now()->diffInDays($this->t->expiration) > 1) {
            return $notifiable->emails_opt_in
                ? ['database', 'mail']
                : ['database'];
        }

        return [];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $hasJoinedSystem = ! $notifiable->is_ghost && $notifiable->signed_up_at;

        $appName = appName(false, $notifiable);
        $appLogo = appLogo(false, $notifiable);
        $kudosText = appLogo(false, $notifiable);

        $buttonText = $hasJoinedSystem
            ? 'Check it out!'
            : "Create Account to share $kudosText with Colleagues";

        $buttonUrl = $hasJoinedSystem
            ? route('kudos.feed')
            : route('user.register', [
                'hash' => $notifiable->invitation->hash,
                'company' => data_get($notifiable->invitation, 'company.alias'),
                'redirect_to' => route('kudos.feed'),
            ]);

        return (new MailMessage())
            ->markdown('notifications::email', [
                'appName' => $appName,
                'appLogo' => $appLogo,
            ])
            ->greeting('Hello,')
            ->subject(
                now()->diffInDays($this->t->expiration).
                    ' Days Left Until '.
                    $kudosText.
                    ' Expire!'
            )
            ->line(
                'You have '.
                    now()->diffInDays($this->t->expiration).
                    ' days left to give away '.
                    $kudosText.
                    ' to amazing people at your company.'
            )
            ->line(
                "You can use $kudosText to buy amazing gift cards and rewards on $appName."
            )
            ->action($buttonText, $buttonUrl)
            ->line("Thank you for using $appName!");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $kudosText = appLogo(false, $notifiable);

        return [
            'obj_id' => $this->t->id,
            'tagline' => 'You have '.
                now()->diffInDays($this->t->expiration).
                ' days left to give away '.
                $kudosText.
                ' to amazing people at your company.',
            'link' => route('login'),
            'type' => "Reminder To Give Away $kudosText",
        ];
    }
}
