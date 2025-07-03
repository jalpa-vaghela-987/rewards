<?php

namespace App\Notifications;

use App\Models\Redemption;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestRewardRedemption extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Redemption
     */
    public $redemption;
    public $reward;
    public $requesterName;
    public $line3;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($redemptionId)
    {
        $this->redemption = $r = Redemption::find($redemptionId);
        $this->requesterName = data_get($this->redemption->user, 'name');
        $this->reward = json_decode($r->data);

        $this->line3 =
            $this->requesterName.
            ' requested a '.
            currencyNumber(
                $this->redemption->value,
                $this->redemption->currency
            ).
            ' '.
            $this->reward->title.
            '.';
        if ($this->reward->use_set_amount && $this->reward->is_custom) {
            $this->line3 =
                $this->requesterName.
                ' requested a '.
                $this->reward->title.
                '.';
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
        $appName = appName(false, $notifiable);
        $appLogo = appLogo(false, $notifiable);

        $m = (new MailMessage())->markdown('notifications::email', [
            'appName' => $appName,
            'appLogo' => $appLogo,
        ]);

        if (! $this->redemption->is_custom) {
            $m->subject(
                $this->requesterName.
                    ' requested a '.
                    currencyNumber(
                        $this->redemption->value,
                        $this->redemption->currency
                    ).
                    ' '.
                    $this->reward->title
            );
        } else {
            $m->subject(
                $this->requesterName.' requested a '.$this->reward->title
            );
        }
        $m->line($this->line3);

        $m->action('See Pending Requests', route('rewards.company'))->line(
            'Thank you for being a superstar!'
        );

        return $m;
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
            'obj_id' => $this->redemption->id,
            'tagline' => $this->line3,
            'link' => route('rewards.company'),
            'type' => 'Redeem '.getReplacedWordOfKudos(),
        ];
    }
}
