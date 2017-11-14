<?php

namespace App\Employee\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EmployeeCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $employee;

    public function __construct($employee)
    {
        $this->employee = $employee;
    }
}
