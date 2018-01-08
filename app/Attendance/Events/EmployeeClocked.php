<?php
namespace App\Attendance\Events;

use App\Attendance\Models\AttendanceTimesheet;
use App\Attendance\Transformers\LiveClockInFeedTransformer;
use App\Attendance\Transformers\LiveClockOutFeedTransformer;
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

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 21/12/17
 * Time: 11:43 AM
 */
class EmployeeClocked implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $clockedData;
    public $clockType;
    public $broadcastQueue = 'broadcaster';

    public function __construct($clockedId, $clockType)
    {
        $this->clockType = $clockType;

        $timesheet = AttendanceTimesheet::find($clockedId);
        if ($clockType == 'in') {
            $this->clockedData = fractal($timesheet, new LiveClockInFeedTransformer());
        } elseif ($clockType == 'out') {
            $this->clockedData = fractal($timesheet, new LiveClockOutFeedTransformer());
        }
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

    public function broadcastWhen()
    {
        return $this->clockedData != null;
    }

}