<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 30/10/17
 * Time: 8:24 PM
 */

use Illuminate\Support\Facades\Route;

/*
 |--------------------------------------------------------------------------
 | Divisions Route
 |--------------------------------------------------------------------------
 */
Route::prefix('doorAccess')->namespace('Client\DoorAccess')->middleware('auth.admin')->group(function () {

    Route::get('/', function () {
        return redirect(route('doorAccess.list'));
    })->name('doorAccess.index');

    Route::get('list', 'ViewController@list')->name('doorAccess.list');
    Route::get('control', 'ViewController@control')->name('doorAccess.control');

});