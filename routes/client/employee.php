<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 31/10/17
 * Time: 6:16 PM
 */

use Illuminate\Support\Facades\Route;

Route::namespace('Client\Employee')->prefix('employee')->middleware('auth.admin')->group(function () {

    Route::get('/', function () {

        // do something here or simply redirect
        return redirect()->route('employee.list');

    })->name('employee');

    Route::get('list', 'ViewController@index')->name('employee.list');
    Route::get('recruitment', 'ViewController@recruitment')->name('employee.recruitment.form');
});