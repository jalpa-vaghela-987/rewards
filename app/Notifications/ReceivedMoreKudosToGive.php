<?php

namespace App\Notifications;

use App\Models\KudosToGiveTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReceivedMoreKudosToGive extends Notification
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
        return $notifiable->emails_opt_in ? ['database', 'mail'] : ['database']; //note adding mail makes this a lot of emails
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
            ? 'Check it out!'
            : 'Create Account to share '.$kudosText.' with Colleagues';

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
            ->subject('Give Away More '.$kudosText.'!')
            ->line(
                'You received more '.
                    $kudosText.
                    ' you can give away to amazing people.'
            )
            ->line(
                'You can use '.
                    $kudosText.
                    ' to buy amazing gift cards and rewards on '.
                    $appName.
                    '.'
            )
            ->action($buttonText, $buttonUrl);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $kudosText = getReplacedWordOfKudos(false, $notifiable);

        return [
            'obj_id' => $this->t->id,
            'tagline' => 'You received '.
                number_format($this->t->amount).
                ' more '.
                $kudosText.
                ' you can give away to amazing people.',
            'link' => '/kudos-feed',
            'type' => 'Received '.$kudosText.' to give',
        ];
    }
}
