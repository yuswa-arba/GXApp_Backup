<?php
namespace App\Attendance\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 21/12/17
 * Time: 11:43 AM
 */
class EmployeeClocked implements ShouldBroadcast
{

    use Dispatchable, InteractsWithSockets, SerializesModels;


//    public $broadcastQueue = 'attendance-broadcast--queue';
    /**
     * @var
     */
    public $person;

    public function __construct($person)
    {

        $this->person = $person;
    }



    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('attendance');
    }

//    public function broadcastAs()
//    {
//        return 'employee.clocked';
//    }

}