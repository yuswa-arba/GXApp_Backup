<?php
namespace App\Account\Observer;
use App\Account\Models\User;

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 2/11/17
 * Time: 11:02 AM
 */
class UserObserver
{
    use \App\Account\Traits\Utils;

    public function creating(User $user)
    {
        /* Insert UUID in id column*/
        $user->{$user->getKeyName()} = $this->generateUUID();
    }
}