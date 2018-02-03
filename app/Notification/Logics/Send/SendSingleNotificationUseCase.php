<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:13 AM
 */

namespace App\Notification\Logics\Send;


use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

abstract class SendSingleNotificationUseCase
{

    public static function notify(Request $request)
    {

        if ($request->viaType == ConfigCodes::$NOTIFY_TYPE['NOTIFICATION']) {
            return (new static)->handleSendViaNotification($request);
        } elseif ($request->viaType == ConfigCodes::$NOTIFY_TYPE['SMS']) {
            return (new static)->handleSendViaSMS($request);
        } else {
            return (new static)->handleSendViaNotification($request); //default
        }


    }

    abstract public function handleSendViaNotification($request);
    abstract public function handleSendViaSMS($request);
}