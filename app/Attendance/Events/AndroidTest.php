<?php
namespace App\Attendance\Events;

use App\Employee\Models\MasterEmployee;
use App\Http\Controllers\BackendV1\Helpdesk\Traits\Configs;
use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**test
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 21/12/17
 * Time: 11:43 AM
 */
class AndroidTest implements ShouldBroadcast
{

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $tries = 5;
    public $broadcastQueue = 'attendance';


    /**
     * @var
     */
    public $message;

    public function __construct()
    {
       $this->message = "Hello @" . Carbon::now();

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