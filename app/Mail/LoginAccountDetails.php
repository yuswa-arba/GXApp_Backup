<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LoginAccountDetails extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $firstPassword;

    public function __construct($user, $firstPassword)
    {
        $this->user = $user;
        $this->firstPassword = $firstPassword;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('layouts.mails.employment.loginAccountDetails');
    }
}
