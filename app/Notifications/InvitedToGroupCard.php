<?php

namespace App\Notifications;

use App\Models\Card;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvitedToGroupCard extends Notification
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
            ? 'Contribute!'
            : 'Create Account to Contribute';

        $actionUrl = $hasJoinedSystem
            ? route('card.build', ['card' => $this->card->id])
            : route('user.register', [
                'hash' => $notifiable->invitation->hash,
                'company' => data_get($notifiable->invitation, 'company.alias'),
                'redirect_to' => route('card.build', [
                    'card' => $this->card->id,
                ]),
            ]);

        return (new MailMessage())
            ->markdown('notifications::email', [
                'appName' => $appName,
                'appLogo' => $appLogo,
            ])
            ->greeting('Hello,')
            ->subject(
                'Invited to contribute to a group card for '.
                    $this->card->receiver->name
            )
            ->line(
                'You have been invited to contribute to a group card for '.
                    $this->card->receiver->name
            )
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
        return [
            //

            'obj_id' => $this->card->id,
            'tagline' => 'You have been invited to contribute to a group card for '.
                $this->card->receiver->name,
            'link' => route('card.build', ['card' => $this->card->id]),
            'type' => 'Group Card Invite',
        ];
    }

    // public function toSlack($notifiable)
    // {
    //     return (new SlackMessage())
    //             ->from(appName())
    //             ->image(appFavicon())
    //             ->to('#kudos-perksweet')
    //             ->content($this->point->reciever->name." received Kudos! \n ".
    //                 htmlspecialchars(trim(strip_tags(htmlspecialchars_decode(html_entity_decode($this->point->message)))))
    //                 ."\n from ". giverName($this->point)
    //             );
    // }
}
