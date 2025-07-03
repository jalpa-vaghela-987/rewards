<?php

namespace App\Mail;

use App\Models\UserInvitation as UI;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserInvitation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user_invitation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(UI $user_invitation)
    {
        $this->user_invitation = $user_invitation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.user-invitation', [
            'sender'    => $this->senderName(),
            'appName'   => $this->getAppName(),
            'appLogo'   => appLogo(false, $this->user_invitation->sender),
            'url'       => url($this->user_invitation->link),
        ])->subject($this->senderName().' has invited you to join '.$this->getAppName().'!');
    }

    public function senderName()
    {
        return $this->user_invitation->sender
            ? $this->user_invitation->sender->name
            : $this->user_invitation->company->name;
    }

    public function getAppName()
    {
        return appName(false, $this->user_invitation->sender);
    }
}
