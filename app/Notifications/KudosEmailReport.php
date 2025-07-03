<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class KudosEmailReport extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $kudos = false;

    public function __construct($kudos)
    {
        if ($kudos) {
            $this->kudos = $kudos;
        }

        if (! app()->environment('production')) {
            $this->delay(now()->addSeconds(2));
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $notifiable->emails_opt_in ? ['mail'] : [];
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
        $kudosText = getReplacedWordOfKudos(false, $notifiable);

        $buttonText = $hasJoinedSystem
            ? __("View $kudosText Feed!")
            : __("Create Account to View $kudosText");

        $buttonUrl = $hasJoinedSystem
            ? route('kudos.feed')
            : route('user.register', [
                'hash' => $notifiable->invitation->hash,
                'company' => data_get($notifiable->invitation, 'company.alias'),
                'redirect_to' => route('kudos.feed'),
            ]);

        return (new MailMessage())
            ->subject($appName.' Weekly Activity Report - '.now()->format('l, F jS, Y'))
            ->markdown('mails.kudos-email-report', [
                'points' => $this->kudos,
                'buttonUrl' => $buttonUrl,
                'buttonText' => $buttonText,
                'appName' => $appName,
                'appLogo' => $appLogo,
                'kudosText' => $kudosText,
            ]);
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
                //
            ];
    }
}
