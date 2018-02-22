<?php
namespace App\Storage\Events;

use App\Attendance\Models\AttendanceTimesheet;
use App\Attendance\Transformers\LiveClockInFeedTransformer;
use App\Attendance\Transformers\LiveClockOutFeedTransformer;
use App\Employee\Models\MasterEmployee;
use App\Http\Controllers\BackendV1\Helpdesk\Traits\Configs;
use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
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
class OrderRequested implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $broadcastQueue = 'broadcaster';
    public $hola;

    public function __construct()
    {
     $this->hola = 'Hola!';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $requisitionStorageId = 2;
        return new PrivateChannel('storage.'.$requisitionStorageId);
    }


}