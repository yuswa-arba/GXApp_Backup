<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 6/11/17
 * Time: 2:12 PM
 */

use Illuminate\Support\Facades\Route;




/*
 |--------------------------------------------------------------------------
 | Setting Route
 |--------------------------------------------------------------------------
 */


Route::prefix('setting')->namespace('Client\Settings')->middleware('auth.admin')->group(function () {

    Route::get('passport', 'ViewController@passport')->name('setting.passport');
    Route::get('permission', 'ViewController@permission')->name('setting.permission');
    Route::get('notification','ViewController@notification')->name('setting.notification');

});
