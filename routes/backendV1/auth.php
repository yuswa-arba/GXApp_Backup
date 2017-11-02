<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 2/11/17
 * Time: 12:22 PM
 */

use Illuminate\Support\Facades\Route;

Route::prefix('bv1')->group(function (){

    Route::namespace('BackendV1')->group(function (){

    });

    Route::prefix('auth')->middleware('web')->group(function (){

        Route::post('login', 'Auth\LoginController@login')->name('bv1.auth.login');

    });



});