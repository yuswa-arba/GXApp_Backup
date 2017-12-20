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

    /*Attendance*/
    Route::namespace('BackendV1\API\Attendance')->prefix('attd')->group(function () {

        Route::middleware('auth:api')->group(function () {

            Route::post('clock/{punchType}', 'MainController@clock');

        });
    });

    /*Kiosk Authentication using passport client_credentials grant type*/
    Route::namespace('BackendV1\API\Attendance')->prefix('kiosk/auth')->group(function () {

        Route::post('login', 'KioskController@login');
        Route::get('getApiToken', 'KioskController@getApiToken');

        Route::middleware('client')->group(function () {

            Route::post('updateToken', 'KioskAuthController@updateAccessToken');
            Route::post('removeAccessToken', 'KioskAuthController@removeAccessToken');
            Route::post('logout', 'KioskAuthController@logout');
            Route::get('test', 'KioskAuthController@test');

        });
    });

    /*Kiosk*/
    Route::namespace('BackendV1\API\Attendance')->prefix('kiosk')->group(function () {


        Route::middleware('client')->group(function () {
            Route::get('av', 'MainController@isAvailableToClock');
            Route::post('clock/{punchType}', 'MainController@clock');

        });
    });

});
