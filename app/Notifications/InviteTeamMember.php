<?php

namespace App\Notifications;

use App\Models\Team;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InviteTeamMember extends Notification
{
    use Queueable;

    public $team;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Team $team)
    {
        $this->team = $team;
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

        $appName = appName();
        $appLogo = appLogo();

        if ($hasJoinedSystem) {
            $appName = appName(false, $notifiable);
            $appLogo = appLogo(false, $notifiable);
        } else {
            $senderId = data_get($notifiable->invitation, 'sender_id');
            if ($senderId && ($sender = User::find($senderId))) {
                $appName = appName(false, $sender);
                $appLogo = appLogo(false, $sender);
            }
        }

        $mailable = (new MailMessage())
            ->markdown('notifications::email', [
                'appName' => $appName,
                'appLogo' => $appLogo,
            ])
            ->greeting('Hello,')
            ->subject('Invited to join '.$this->team->name)
            ->line('You have been invited to join a '.$this->team->name);

        if ($hasJoinedSystem) {
            $mailable->action(
                'View Team!',
                route('view.team', ['team' => $this->team->id])
            );
        } else {
            $mailable->action(
                'Create Account to View Team',
                route('user.register', [
                    'hash' => $notifiable->invitation->hash,
                    'company' => data_get(
                        $notifiable->invitation,
                        'company.alias'
                    ),
                    'redirect_to' => route('view.team', [
                        'team' => $this->team->id,
                    ]),
                ])
            );
        }

        return $mailable->line('Thank you for using '.$appName.'!');
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
            'obj_id' => $this->team->id,
            'tagline' => 'You have been invited to join a '.$this->team->name,
            'link' => route('view.team', ['team' => $this->team->id]),
            'type' => 'Team Invite',
        ];
    }
}
