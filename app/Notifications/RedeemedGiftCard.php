<?php

namespace App\Notifications;

use App\Models\Redemption;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class RedeemedGiftCard extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $redemption;
    private $reward;
    private $redemption_instructions = '';
    private $line3 = '';
    private $line4 = '';
    private $currency;

    public function __construct(Redemption $r)
    {
        $this->redemption = $r;
        $this->reward = json_decode($r->data);

        if ($this->redemption->is_custom) {
            $this->redemption_instructions = $this->redemption->redemption_instructions;
        }

        $this->line3 = 'You received a '.currencyNumber($this->redemption->value, $this->redemption->currency).' '.$this->reward->title.'.';
        $this->line4 = 'Cost: '.number_format($this->redemption->cost).' '.getReplacedWordOfKudos();

        if ($this->reward->use_set_amount && $this->reward->is_custom) {
            $this->line3 = 'You received a '.$this->reward->title.'.';
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
        return $notifiable->emails_opt_in
            ? ['database', 'mail']
            : ['database'];
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

        $mail = (new MailMessage())->markdown('notifications::email', [
            'appName' => $appName,
            'appLogo' => $appLogo,
        ]);

        if ($this->redemption->is_custom) {
            $mail->subject('You redeemed '.$kudosText.' for a '.$this->reward->title);
        } else {
            $mail->subject('You redeemed '.$kudosText.' for a '.currencyNumber($this->redemption->value, $this->currency).' '.$this->reward->title);
        }

        $mail->greeting('Congratulations! 🎉🎊🧁')->line($this->line3);

        if ($this->line4) {
            $mail->line($this->line4);
        }

        if ($this->redemption_instructions) {
            $mail->line('Redemption Instructions: '.$this->redemption_instructions ?? ' ');
        }

        if ($this->reward->photo_path) {
            $mail->line(new HtmlString(sprintf("<center><img src='%s'></center>", $this->reward->photo_path)));
        }

        if ($this->redemption->is_custom && $this->redemption->redemption_code) {
            $mail->line($appName.' Redemption Code: '.$this->redemption->redemption_code);
        }

        $mail->action('View Gift Card', $this->redemption->tango_link ?? route('purchased', ['redemption' => $this->redemption->id]))
            ->line('Thank you for being a superstar!');

        return $mail;
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
            'tagline' => $this->line3,
            'link' => route('purchased', [
                'redemption' => $this->redemption->id,
            ]),
            'type' => "Redeemed $kudosText",
        ];
    }
}
