<?php

namespace App\Employee\Listeners;

use App\Employee\Events\UserGenerated;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendLoginDetailsEmail implements ShouldQueue
{
    use InteractsWithQueue;


    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserGenerated  $event
     * @return void
     */
    public function handle(UserGenerated $event)
    {
        // TODO : Send login details
        Log::info("Send user login detail " . $event->user->email . ' '. $event->firstPassword);
    }

    public function failed(UserGenerated $event,$exception)
    {

    }
}
