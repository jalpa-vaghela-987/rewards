<?php

namespace App\Mail;

use App\Models\Company;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompanyRegistered extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $company;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Company $company, User $user)
    {
        $this->company = $company;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.company-registered', [
            'appName'   => appName(false, $this->user),
            'appLogo'   => appLogo(false, $this->user),
        ]);
    }
}
