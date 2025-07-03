<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RemindToContributeInGroupCard extends Notification implements ShouldQueue
{
    use Queueable;

    public $card;
    public $users;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($card)
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
        $channels = ['database'];

        if ($notifiable->emails_opt_in) {
            $channels[] = 'mail';
        }

        return $channels;
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

        $cardOwnerName = data_get($this->card->creator, 'name');
        $receiverName = data_get($this->card->receiver, 'name');

        return (new MailMessage())
            ->subject('Reminder to Contribute to Group Card for '.$receiverName)
            ->markdown('notifications::email', ['appName' => $appName, 'appLogo' => $appLogo])
            ->line("$cardOwnerName invited you to contribute to a group card for $receiverName.")
            ->line("Group cards on $appName are a great way to celebrate any occasion. Add meaningful note and easily include a Gif, photo, or personalized video to amplify the message!")
            ->action('Contribute Now', route('card.build', ['card' => $this->card]))
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
        $receiverName = data_get($this->card->receiver, 'name');

        return [
            'obj_id' => $this->card->id,
            'tagline' => "Reminder: Contribute To A Group Card for $receiverName",
            'link' => route('card.build', ['card' => $this->card]),
            'type' => 'Contribute to Group Card',
        ];
    }
}
