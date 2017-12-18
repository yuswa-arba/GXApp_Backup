<?php

namespace App\Employee\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

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
