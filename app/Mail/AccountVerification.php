<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccountVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $employee;


    public function __construct($employee)
    {
        $this->employee = $employee;
    }


    public function build()
    {
        return $this->view('layouts.mails.employment.accountVerification')->subject('GXApp Account Verification');
    }
}
