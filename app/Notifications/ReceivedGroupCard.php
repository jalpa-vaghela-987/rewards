<?php

namespace App\Notifications;

use App\Models\Card;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReceivedGroupCard extends Notification
{
    use Queueable;

    public $card;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Card $card)
    {
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
        return $notifiable->emails_opt_in ? ['database', 'mail'] : ['database'];
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

        $actionText = $hasJoinedSystem
            ? 'View Group Card'
            : 'Create Account to View Group Card';

        $actionUrl = $hasJoinedSystem
            ? route('card.view', $this->card->token)
            : route('user.register', [
                'hash' => $notifiable->invitation->hash,
                'company' => data_get($notifiable->invitation, 'company.alias'),
                'redirect_to' => route('card.view', $this->card->token),
            ]);

        return (new MailMessage())
            ->markdown('notifications::email', [
                'appName' => $appName,
                'appLogo' => $appLogo,
            ])
            ->greeting('Hello,')
            ->subject($this->card->headline.' —'.$appName.' Group Card')
            ->line('You received a group card from members of your team!')
            ->line(
                $appName.
                    ' Group Cards allow you to enter a customizable message with a variety of media options for any occasion.'
            )
            ->action($actionText, $actionUrl)
            ->line('Thank you for using '.$appName.'!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $appName = appName(false, $notifiable);

        return [
            //

            'obj_id' => $this->card->id,
            'tagline' => $this->card->headline.' —'.$appName.' Group Card',
            'link' => route('card.view', $this->card->token),
            'type' => 'Received Group Card',
        ];
    }
}
