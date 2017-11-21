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

    }

    public function created()
    {

    }

    public function saving()
    {

    }

    public function saved()
    {

    }
}