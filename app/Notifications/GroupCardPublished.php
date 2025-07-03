<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GroupCardPublished extends Notification implements ShouldQueue
{
    use Queueable;

    public $user;
    public $card;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $card)
    {
        $this->user = $user;
        $this->card = $card;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $appName = appName(false, $notifiable);
        $appLogo = appLogo(false, $notifiable);

        return (new MailMessage())
            ->markdown('notifications::email', [
                'appName' => $appName,
                'appLogo' => $appLogo,
            ])
            ->subject(
                $this->card->headline.
                    ' —'.
                    $appName.
                    ' Group Card Contribution'
            )
            ->greeting('Hello,')
            ->line($this->user->name.' contributed to the group card!')
            //            ->line(html_entity_decode(htmlspecialchars_decode($this->cardElement->text)))
            ->action('View Group Card', route('card.build', $this->card->id))
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
        return [
            'obj_id' => $this->card->id,
            'tagline' => $this->user->name.
                ' published to the group card created by you',
            'link' => route('card.build', ['card' => $this->card->id]),
        ];
    }
}
