<?php

namespace App\Employee\Events;

use App\Account\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserGenerated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $user;
    public $firstPassword;

    public function __construct($user, $firstPassword)
    {
        $this->user = $user;
        $this->firstPassword = $firstPassword;
    }

}
