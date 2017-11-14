<?php

namespace App\Employee\Listeners;

use App\Employee\Events\EmployeeCreated;
use App\Mail\AccountVerification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmployeeDataVerification implements ShouldQueue
{

    use InteractsWithQueue;

    public function __construct()
    {
        //
    }

    /**
     * send email employee data verification
     */
    public function handle(EmployeeCreated $event)
    {
        $message = (new AccountVerification($event->employee))->onConnection('database')->onQueue('emails');
        Mail::to($event->employee->email)->queue($message);
    }


    public function failed(EmployeeCreated $event, $exception)
    {
        //TODO : what to do when is failed
    }

}
