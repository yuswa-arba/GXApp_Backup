<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 2/11/17
 * Time: 12:22 PM
 */

use Illuminate\Support\Facades\Route;

/* v1/a = version 1 Android API */
Route::prefix('v1/a')->group(function () {

    Route::namespace('BackendV1\API\Inbox')->prefix('inbox')->group(function () {

        Route::middleware('auth:api')->group(function () {

            Route::get('pushNotification/list', 'PushNotificationController@getPushNotificationList');
            Route::post('pushNotification/seen', 'PushNotificationController@seenPushNotification');

        });

    });

});