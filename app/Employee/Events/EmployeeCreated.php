<?php

namespace App\Employee\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class EmployeeCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $employee;

    public function __construct($employee)
    {
        $this->employee = $employee;
    }
}
