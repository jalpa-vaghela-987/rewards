<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsChannel;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsMessage;

class TestNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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

        if ($notifiable->company->enable_slack) {
            $channels[] = 'slack';
        }

        if ($notifiable->company->enable_microsoft_teams) {
            $channels[] = MicrosoftTeamsChannel::class;
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

        return (new MailMessage())
            ->markdown('notifications::email', [
                'appName' => $appName,
                'appLogo' => $appLogo,
            ])
            ->greeting('Test Notification')
            ->subject('Test Notification')
            ->line('Test Notification.')
            ->action('link', '/kudos-feed');
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
            'obj_id' => $notifiable->id,
            'tagline' => 'Test Notification',
            'link' => route('kudos.feed'),
            'type' => 'Test Notification',
        ];
    }

    public function toSlack($notifiable)
    {
        $appName = appName(false, $notifiable);
        $appFavicon = appFavicon(false, $notifiable);

        return (new SlackMessage())
            ->from($appName)
            ->image($appFavicon)
            ->to('#kudos-perksweet')
            ->content('Test Notification');
    }

    public function toMicrosoftTeams($notifiable)
    {
        $appName = appName(false, $notifiable);

        return MicrosoftTeamsMessage::create()
            ->type('success')
            ->title($appName)
            ->content('Test Notification');
    }
}
