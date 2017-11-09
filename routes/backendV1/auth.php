<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 2/11/17
 * Time: 12:22 PM
 */

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::namespace('BackendV1\Auth')->prefix('auth')->group(function (){

        Route::post('register', 'LoginController@register');
        Route::post('login', 'LoginController@login');
        Route::post('refresh', 'LoginController@refresh');

        Route::group(['middleware' => 'auth:api'], function () {

            Route::post('logout', 'LoginController@logout');

        });

    });


});