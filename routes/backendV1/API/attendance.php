<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 19/12/17
 * Time: 8:32 AM
 */

/* v1/a = version 1 Android API */
use Illuminate\Support\Facades\Route;

Route::prefix('v1/a')->group(function () {

    Route::namespace('BackendV1\API\Attendance')->prefix('attd')->group(function () {

        Route::middleware('auth:api')->group(function () {

            Route::post('clockIn', 'MainController@clockIn');
            Route::post('clockOut', 'MainController@clockOut');
        });
    });

    Route::namespace('BackendV1\API\Attendance')->prefix('kiosk')->group(function () {

        Route::post('login', 'KioskController@login');
        Route::get('getApiToken', 'KioskController@getApiToken');

        Route::middleware('client')->group(function () {

            Route::post('updateToken', 'KioskAuthController@updateAccessToken');
            Route::post('removeAccessToken', 'KioskAuthController@removeAccessToken');
            Route::post('logout', 'KioskAuthController@logout');
            Route::get('test', 'KioskAuthController@test');

        });
    });

});
