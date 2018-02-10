<?php
namespace App\Components\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
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
class HeartBeat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function broadcastOn()
    {
        return new Channel('connection');
    }
}