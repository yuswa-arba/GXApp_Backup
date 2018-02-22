<?php
namespace App\Account\Events;

use App\Notification\Models\Notifications;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Auth;

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 21/12/17
 * Time: 11:43 AM
 */
class UserNotified implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $broadcastQueue = 'broadcaster';

    public $employeeId;

    public $title;
    public $message;
    public $url;

    public function __construct($employeeId,$notificationId)
    {
        $this->employeeId = $employeeId;
        $notification = Notifications::find($notificationId);

        if($notification){
            $this->title = $notification->title;
            $this->message = $notification->message;
            $this->url = $notification->url;
        }

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('notify.' . $this->employeeId);
    }


}