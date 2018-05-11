<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 6/11/17
 * Time: 4:50 PM
 */


/*
 |--------------------------------------------------------------------------
 | Setting Route
 |--------------------------------------------------------------------------
 */


use Illuminate\Support\Facades\Route;

//Route::prefix('v1/setting')->namespace('BackendV1\Settings')->middleware('auth.admin:api')->group(function () {
Route::prefix('v1/h')->group(function () {
    Route::prefix('misc')->namespace('BackendV1\Helpdesk\Misc')->group(function () {

        Route::post('notification/send/single','NotificationController@sendSingleNotification');

    });
});