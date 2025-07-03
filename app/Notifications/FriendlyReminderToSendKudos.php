<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FriendlyReminderToSendKudos extends Notification implements ShouldQueue
{
    use Queueable;

    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $appName = appName(false, $notifiable);
        $appLogo = appLogo(false, $notifiable);
        $kudosText = getReplacedWordOfKudos(false, $notifiable);

        return (new MailMessage)
            ->markdown('notifications::email', compact('appLogo', 'appName', 'kudosText'))
            ->subject("$appName - Friendly $kudosText Reminder")
            ->line("We noticed you have not sent $kudosText in a while. You should reward someone special with $kudosText on $appName!")
            ->action('Send Kudos', route('kudos.feed'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $appName = appName(false, $notifiable);
        $kudosText = getReplacedWordOfKudos(false, $notifiable);

        return [
            'obj_id'    => $notifiable->id,
            'tagline'   => "$appName - Friendly $kudosText Reminder",
            'link'      => route('kudos.feed'),
            'type'      => "Reminder To Give Away $kudosText",
        ];
    }
}
