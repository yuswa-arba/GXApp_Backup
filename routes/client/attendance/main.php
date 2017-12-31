<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 22/11/17
 * Time: 3:33 PM
 */

/*
 |--------------------------------------------------------------------------
 | Setting Route
 |--------------------------------------------------------------------------
 */


use Illuminate\Support\Facades\Route;

Route::prefix('attendance')->namespace('Client\Attendance')->middleware('auth.admin')->group(function () {


    Route::get('/', function(){
        // do something here or simply redirect
        return redirect()->route('attendance.dashboard');
    })->name('attendance');

    Route::get('dashboard/', 'ViewController@dashboard')->name('attendance.dashboard');
    Route::get('setting/', 'ViewController@setting')->name('attendance.setting');
    Route::get('slot/', 'ViewController@slot')->name('attendance.slot');
    Route::get('timesheet', 'ViewController@timesheet')->name('attendance.timesheet');
});
