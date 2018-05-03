<?php

namespace App\Mail\Listeners;

use App\Traits\GlobalUtils;
use Exception;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SendingMessageListener implements ShouldQueue
{
    use InteractsWithQueue;
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
     * @param  MessageSending $event
     * @return void
     */
    public function handle(MessageSending $event)
    {
        try{
            app()->make('LogService')->logging([
                'causer' => 'Undefined',
                'via' => 'web client| api client',
                'subject' => 'Sending Mail',
                'action' => 'mail',
                'level' => 1,
                'description' =>  $event->message,
                'causerIPAddress' => \Request::ip()
            ]);
        } catch (Exception $exception){
            //do nothing
            Log::error($exception->getMessage());
        }

    }


}
