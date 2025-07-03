<?php

namespace App\Notifications;

use App\Models\KudosToGiveTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeToPerkSweet extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
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
        $company = $notifiable->company;
        $appName = appName(false, $notifiable);
        $appLogo = appLogo(false, $notifiable);
        $kudosText = getReplacedWordOfKudos(false, $notifiable);

        if ($notifiable->role == 1 && $company->users->count() < 10) {
            return (new MailMessage())
                ->markdown('notifications::email', [
                    'appName' => $appName,
                    'appLogo' => $appLogo,
                ])
                ->greeting('Welcome to '.$appName.'!')
                ->subject('Welcome to '.$appName.'!')
                ->line(
                    $appName.' is an Employee Engagement & Rewards Platform.'
                )
                ->line(
                    $appName.
                        ' lets you easily say thank you, congrats, farewell, great job, and much more to your team.'
                )
                ->line(
                    'The platform allows you to send '.
                        $kudosText.
                        ' to other amazing people at your company, share customizable group cards, and much more!'
                )
                ->line(
                    $appName.
                        ' '.
                        $kudosText.
                        ' can be redeemed for gift cards and rewards.'
                )
                ->line(
                    'To get started, you received '.
                        $kudosText.
                        ' that you can give away to others.'
                )
                ->line(
                    'In order to send '.
                        $kudosText.
                        ' you will need to invite more amazing people!'
                )
                ->action('Invite Users!', route('company.manage.users'))
                ->line('Thank you for using '.$appName.'!');
        }

        return (new MailMessage())
            ->markdown('notifications::email', [
                'appName' => $appName,
                'appLogo' => $appLogo,
            ])
            ->greeting('Welcome to '.$appName.'!')
            ->subject('Welcome to '.$appName.'!')
            ->line($appName.' is an Employee Engagement & Rewards Platform.')
            ->line(
                $appName.
                    ' lets you easily say thank you, congrats, farewell, great job, and much more to your team.'
            )
            ->line(
                'The platform allows you to send '.
                    $kudosText.
                    ' to other amazing people at your company, share customizable group cards, and much more!'
            )
            ->line(
                $appName.
                    ' '.
                    $kudosText.
                    ' can be redeemed for gift cards and rewards.'
            )
            ->line(
                'To get started, you received '.
                    $kudosText.
                    ' that you can give away to others.'
            )
            ->line(
                'In order to send '.
                    $kudosText.
                    ' you will need to invite more amazing people!'
            )
            ->action('Check it out!', route('kudos.feed'))
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
        $kudosText = getReplacedWordOfKudos(false, $notifiable);

        $company = $notifiable->company;
        if ($notifiable->role == 1 && $company->users->count() < 10) {
            return [
                'obj_id' => $this->t->id,
                'tagline' => 'Welcome to '.
                    $appName.
                    '! The platform allows you to send '.
                    $kudosText.
                    ' to other amazing people at your company, share customizable group cards, and much more. '.
                    $appName.
                    ' '.
                    $kudosText.
                    ' can be redeemed for gift cards and rewards. In order to send '.
                    $kudosText.
                    ' you will need to invite more amazing people!',
                'link' => route('company.manage.users'),
                'type' => 'Welcome to '.$appName,
            ];
        }

        return [
            'obj_id' => $this->t->id,
            'tagline' => 'Welcome to '.
                $appName.
                '! The platform allows you to send '.
                $kudosText.
                ' to other amazing people at your company, share customizable group cards, and much more. '.
                $appName.
                ' '.
                $kudosText.
                ' can be redeemed for gift cards and rewards. In order to send '.
                $kudosText.
                ' you will need to invite more amazing people!',
            'link' => route('kudos.feed'),
            'type' => 'Welcome to '.$appName,
        ];
    }
}
