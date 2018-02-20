<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 31/10/17
 * Time: 6:16 PM
 */

use Illuminate\Support\Facades\Route;

Route::namespace('Client\Profile')->prefix('profile')->middleware('auth')->group(function () {

    Route::get('/', function () {

        // do something here or simply redirect
        return redirect()->route('profile.index');

    })->name('employee');

    Route::get('index', 'ViewController@index')->name('profile.index');

});