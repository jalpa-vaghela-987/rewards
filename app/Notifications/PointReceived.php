<?php

namespace App\Notifications;

use App\Models\Point;
use App\Models\User;
use Html2Text\Html2Text;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsChannel;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsMessage;

class PointReceived extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $point;
    private $text;
    private $tagLine;
    private $appName;
    private $kudosWord;
    private $appLogo;

    public function __construct(Point $point, $tagLine = null)
    {
        $this->point = $point;

        $html = new Html2Text(
            html_entity_decode(htmlspecialchars_decode($this->point->message))
        );
        $this->text = $html->getText();

        $this->tagLine = $tagLine;

        $this->appName = appName();
        $this->kudosWord = getReplacedWordOfKudos();
        $this->appLogo = appLogo();
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
        $hasJoinedSystem = ! $notifiable->is_ghost && $notifiable->signed_up_at;

        $appName = $this->appName;
        $kudosWord = $this->kudosWord;
        $appLogo = $this->appLogo;

        if ($hasJoinedSystem) {
            $appName = appName(false, $notifiable);
            $appLogo = appLogo(false, $notifiable);
            $kudosWord = getReplacedWordOfKudos(false, $notifiable);
        } else {
            $senderId = data_get($notifiable->invitation, 'sender_id');
            if ($senderId && ($sender = User::find($senderId))) {
                $appName = appName(false, $sender);
                $appLogo = appLogo(false, $sender);
                $kudosWord = getReplacedWordOfKudos(false, $sender);
            }
        }

        $actionText = $hasJoinedSystem
            ? "View $kudosWord"
            : "Create Account to View $kudosWord";

        $actionUrl = $hasJoinedSystem
            ? route('kudos.received', ['point' => $this->point->id])
            : route('user.register', [
                'hash' => $notifiable->invitation->hash,
                'company' => data_get($notifiable->invitation, 'company.alias'),
                'redirect_to' => route('kudos.received', [
                    'point' => $this->point->id,
                ]),
            ]);

        return (new MailMessage())
            ->markdown('notifications::email', [
                'appName' => $appName,
                'appLogo' => $appLogo,
            ])
            ->greeting('Congratulations! 🎉🎊🧁')
            ->subject(giverName($this->point).' sent you '.$kudosWord)
            ->line('You received '.number_format($this->point->amount).' '.$kudosWord.' from '.giverName($this->point).'.')
            ->line(new HtmlString('<hr>'))
            ->line(
                new HtmlString(
                    html_entity_decode(
                        htmlspecialchars_decode($this->point->message)
                    )
                )
            )
            ->line(new HtmlString('<hr>'))
            ->line('You can use '.$kudosWord.' to buy amazing gift cards and rewards on '.$appName.'.')
            ->action($actionText, $actionUrl)
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
        return [
            'obj_id' => $this->point->id,
            'tagline' => giverName($this->point).' sent you '.number_format($this->point->amount).' '.getReplacedWordOfKudos(false, $notifiable),
            'link' => route('kudos.received', ['point' => $this->point->id]),
            'type' => 'Received '.getReplacedWordOfKudos(false, $notifiable),
        ];
    }

    public function toSlack($notifiable)
    {
        return (new SlackMessage())
            ->from(appName(false, $notifiable))
            ->image(appFavicon(false, $notifiable))
            ->to('#kudos-perksweet')
            ->content($this->point->reciever->name.' received '.getReplacedWordOfKudos(false, $notifiable)."! \n".$this->text."\n from ".giverName($this->point));
    }

    public function toMicrosoftTeams($notifiable)
    {
        return MicrosoftTeamsMessage::create()
            ->type('success')
            ->title(appName(false, $notifiable))
            ->content($this->point->reciever->name.' received '.getReplacedWordOfKudos(false, $notifiable)."! \n".$this->text."\n from ".giverName($this->point));
    }
}
