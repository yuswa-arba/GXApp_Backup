<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 28/12/17
 * Time: 3:14 PM
 */


use Illuminate\Support\Facades\Route;

Route::prefix('v1/h')->group(function () {
//    Route::prefix('attendance')->namespace('BackendV1\Helpdesk\Developer')->middleware('auth.admin')->group(function (){
    Route::prefix('developer')->namespace('BackendV1\Helpdesk\Developer')->group(function () {



    });
});