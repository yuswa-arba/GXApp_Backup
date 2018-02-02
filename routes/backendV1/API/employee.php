<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 19/12/17
 * Time: 8:32 AM
 */

/* v1/a = version 1 Android API */
use Illuminate\Support\Facades\Route;

/* v1/a = version 1 Android API */
Route::prefix('v1/a')->group(function () {

    Route::namespace('BackendV1\API\Employee')->prefix('employee')->group(function (){

        Route::middleware('auth:api')->group(function () {

            Route::post('profile/change/password', 'ProfileController@changePassword');

        });

    });

});