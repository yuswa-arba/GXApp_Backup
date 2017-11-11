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

    Route::namespace('BackendV1\Android\Auth')->prefix('auth')->group(function (){

        Route::post('register', 'LoginController@register');
        Route::post('login', 'LoginController@login');
        Route::post('refresh', 'LoginController@refresh');


        Route::middleware('auth:api')->group(function () {

            Route::post('logout', 'LoginController@logout');

        });

    });

});