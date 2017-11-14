<?php

namespace App\Employee\Listeners;

use App\Employee\Events\EmployeeCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendEmployeeDataVerification
{

    use InteractsWithQueue;

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
     * @param  EmployeeCreated  $event
     * @return void
     */
    public function handle(EmployeeCreated $event)
    {
        //TODO : send email employee data verification
        Log::info('Send employee data verification ' . $event->employee->nickName);
    }


    public function failed(EmployeeCreated $event,$exception){

    }

}
