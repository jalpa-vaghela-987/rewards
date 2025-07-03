<?php

namespace App\Notifications;

use App\Models\Redemption;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UnableToFulfillGiftCard extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $redemption;
    private $reward;
    private $failing_reason = '';
    private $tagline = '';

    public function __construct(Redemption $r, $failing_reason)
    {
        $this->redemption = $r;
        $this->reward = json_decode($r->data);
        $this->failing_reason = $failing_reason;
        $this->tagline =
            currencyNumber(
                $this->redemption->value,
                $this->redemption->currency
            ).
            ' '.
            $this->reward->title.
            ' redemption failed.';
        if ($this->reward->use_set_amount && $this->reward->is_custom) {
            $this->tagline = $this->reward->title.' redemption failed.';
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

        return (new MailMessage())
            ->markdown('notifications::email', [
                'appName' => $appName,
                'appLogo' => $appLogo,
            ])
            ->subject($this->tagline)
            //            ->greeting('Oops!')
            ->line($this->tagline)
            ->line('Failing Reason: '.$this->failing_reason ?? ' ');
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
            'obj_id' => $this->redemption->id,
            'tagline' => $this->tagline,
            'link' => '/redemption/'.$this->redemption->id,
            'type' => 'Redeemed '.$kudosText,
        ];
    }
}
