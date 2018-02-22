<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

use App\Notification\Models\NotificationRecipientGroup;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int)$user->id === (int)$id;
});


Broadcast::channel('storage.{groupTypeId}', function ($user,$groupTypeId) {

    $employee = $user->employee;

    if (!$employee){
        return false;
    }

    $checkRecipient =  NotificationRecipientGroup::where('employeeId',$employee->id)
                    ->where('groupTypeId',$groupTypeId)->count();

    if($checkRecipient>0){
        return true;
    } else {
        return false;
    }

});