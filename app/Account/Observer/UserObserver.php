<?php
namespace App\Account\Observer;
use App\Account\Models\User;
use App\Traits\GlobalUtils;

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 2/11/17
 * Time: 11:02 AM
 */
class UserObserver
{
    use GlobalUtils;

    public function creating(User $model)
    {
        /* Insert UUID in id column*/
        $model->{$model->getKeyName()} = $this->generateUUID();
    }
}