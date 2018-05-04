<?php

namespace App\Mail\Listeners;

use App\Traits\GlobalUtils;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SentMessageListener
{
    use GlobalUtils;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MessageSent  $event
     * @return void
     */
    public function handle(MessageSent $event)
    {
        try{
            app()->make('LogService')->logging([
                'causer' => 'Undefined',
                'via' => 'web client| api client',
                'subject' => 'Sent Mail',
                'action' => 'mail',
                'level' => 1,
                'description' => 'Message Sent',
                'causerIPAddress' => \Request::ip()
            ]);
        } catch (\Exception $exception){
            //do nothing
            Log::error($exception->getMessage());
        }

    }
}
