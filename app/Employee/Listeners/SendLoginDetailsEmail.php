<?php

namespace App\Employee\Listeners;

use App\Employee\Events\UserGenerated;

use App\Mail\LoginAccountDetails;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendLoginDetailsEmail implements ShouldQueue
{
    use InteractsWithQueue;


    public function __construct()
    {
        //
    }

    /**
     * Send login details email
     */
    public function handle(UserGenerated $event)
    {
        $message = (new LoginAccountDetails($event->user,$event->firstPassword))->onConnection('database')->onQueue('emails');
        Mail::to($event->user->email)->queue($message);
    }

    public function failed(UserGenerated $event,$exception)
    {

    }
}
