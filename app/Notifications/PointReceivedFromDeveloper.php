<?php

namespace App\Notifications;

use App\Models\Point;
use Html2Text\Html2Text;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class PointReceivedFromDeveloper extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $point;
    private $text;

    public function __construct(Point $point)
    {
        $this->point = $point;

        $html = new Html2Text(
            html_entity_decode(htmlspecialchars_decode($this->point->message))
        );
        $this->text = $html->getText();

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
        if ($notifiable->emails_opt_in) {
            return ['database', 'mail'];
        }

        return ['database'];
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
        $kudosText = getReplacedWordOfKudos(false, $notifiable);

        return (new MailMessage())
            ->markdown('notifications::email', [
                'appName' => $appName,
                'appLogo' => $appLogo,
            ])
            ->greeting('Congratulations! 🎉🎊🧁')
            ->subject(giverName($this->point).' sent you '.$kudosText.'!')
            ->line('You received '.number_format($this->point->amount).' '.$kudosText.' from '.giverName($this->point).'.')
            ->line('You can use '.$kudosText.' to buy amazing gift cards and rewards on '.$appName.'.')
            ->action('View '.$kudosText, route('kudos.received', [
                'point' => $this->point->id,
            ]))
            ->line('Keep being amazing!');
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
            'obj_id' => $this->point->id,
            'tagline' => giverName($this->point).' sent you '.number_format($this->point->amount).' '.$kudosText.'!',
            'link' => route('kudos.received', ['point' => $this->point->id]),
            'type' => 'Received '.$kudosText,
        ];
    }

    public function toSlack($notifiable)
    {
        return (new SlackMessage())
            ->from(appName())
            ->image(appFavicon())
            ->to('#kudos-perksweet')
            ->content($this->point->reciever->name.' received '.getReplacedWordOfKudos()."! \n".$this->text."\n from ".giverName($this->point));
    }
}
