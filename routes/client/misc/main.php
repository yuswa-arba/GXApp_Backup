<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 31/10/17
 * Time: 6:16 PM
 */

use Illuminate\Support\Facades\Route;

Route::namespace('Client\Misc')->prefix('misc')->middleware('auth.admin')->group(function () {

    Route::get('/', 'ViewController@index')->name('misc.index');
    Route::get('notification/','ViewController@notification')->name('misc.notification');

});