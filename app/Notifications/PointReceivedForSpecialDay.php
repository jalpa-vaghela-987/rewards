<?php

namespace App\Notifications;

use App\Models\Point;
use Carbon\Carbon;
use Html2Text\Html2Text;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsChannel;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsMessage;

class PointReceivedForSpecialDay extends Notification
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
    private $special_day;

    public function __construct(Point $point, $specialDay)
    {
        $this->point = $point;

        $html = new Html2Text(
            html_entity_decode(htmlspecialchars_decode($this->point->message))
        );
        $this->text = $html->getText();

        $this->special_day = $specialDay;
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
        $kudosText = getReplacedWordOfKudos(false, $notifiable);

        return (new MailMessage())
            ->markdown('notifications::email', [
                'appName' => $appName,
                'appLogo' => $appLogo,
            ])
            ->subject($this->subject($notifiable))
            ->greeting($this->title($notifiable))
            ->line($this->body(true, $kudosText));
        //            ->action('View Kudos', '/received/'.$this->point->id)
        //            ->line('Keep being amazing!');
    }

    public function subject($notifiable)
    {
        return $this->title($notifiable);
    }

    public function title($notifiable)
    {
        $title = 'Happy ';

        if ($this->special_day === Point::TYPE_ANNIVERSARY) {
            $title .=
                Carbon::parse($notifiable->anniversary)->diffInYears().
                ' Year ';
        }

        return $title.
            trans('point.'.$this->special_day).
            ', '.
            $notifiable->name.
            '!';
    }

    public function body($withAmount = true, $kudosText = null)
    {
        $kudosText = $kudosText ?? getReplacedWordOfKudos();

        $body = '';

        if ($this->point->amount && $withAmount) {
            $body =
                'You received '.
                $this->point->amount.
                ' '.
                $kudosText.
                ' !';
        }

        return $body.
            ' '.
            trans('point.special-day.'.$this->special_day.'.message-body');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $specialDay = trans('point.'.$this->special_day);

        if ($this->special_day === Point::TYPE_ANNIVERSARY) {
            $specialDay =
                Carbon::parse($notifiable->anniversary)->diffInYears().
                ' Year '.
                $specialDay;
        }

        $tagline = trans('point.special-message', [
            'name' => config('app.name'),
            'special_day' => $specialDay,
        ]);

        return [
            'obj_id' => $this->point->id,
            'tagline' => $tagline,
            'link' => route('kudos.received', ['point' => $this->point->id]),
            'type' => 'Received Kudos',
        ];
    }

    public function toSlack($notifiable)
    {
        $content = $this->title($notifiable)." \n";
        $content .= $this->body(false)." \n";
        $content .= 'from '.giverName($this->point);

        return (new SlackMessage())
            ->from(appName())
            ->image(appFavicon())
            ->to('#kudos-perksweet')
            ->content($content);
    }

    public function toMicrosoftTeams($notifiable)
    {
        $content = $this->title($notifiable)." \n";
        $content .= $this->body(false)." \n";
        $content .= 'from '.giverName($this->point);

        return MicrosoftTeamsMessage::create()
            ->type('success')
            ->title(appName())
            ->content($content);
    }
}
