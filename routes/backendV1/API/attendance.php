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

        Route::post('login', 'KioskAuthController@login');
        Route::get('getApiToken', 'KioskAuthController@getApiToken');

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
            /* @url api/v1/a/kiosk/clock/{punchType}
             * @header Authorization Bearer <kiosk_api_token>
             *
             * @param punchType in/out
             * @body cViaTypeId int
             * @body employeeId uuid
             * */
            Route::post('clock/{punchType}', 'MainController@clock');

        });
    });

});
