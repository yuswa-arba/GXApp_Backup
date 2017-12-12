<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 3/11/17
 * Time: 4:27 PM
 */


use Illuminate\Support\Facades\Route;


/* v1/h = version 1 Helpdesk API */
Route::prefix('v1/h')->group(function () {
//    Route::prefix('attendance')->namespace('BackendV1\Helpdesk\Attendance')->middleware('auth.admin')->group(function (){
    Route::prefix('attendance')->namespace('BackendV1\Helpdesk\Attendance')->group(function () {

        Route::get('slotMaker/list', 'SlotMakerController@list')->name('v1.slotMaker.list');
        Route::post('slotMaker/create', 'SlotMakerController@create')->name('v1.slotMaker.create');
        Route::post('slotMaker/execute','SlotMakerController@execute')->name('v1.slotMaker.execute');

        Route::get('slot/list','SlotController@list')->name('v1.slot.list');
        Route::get('slot/detail/calendar','SlotController@calendar')->name('v1.slot.calendar');
        Route::get('slot/assign/employee','SlotController@employeeList')->name('v1.slot.assign.get.employee');
        Route::post('slot/assign/employee','SlotController@assign')->name('v1.slot.assign.employee');
        Route::post('slot/remove/employee','SlotController@remove')->name('v1.slot.remove.employee');

        Route::post('shift/create','ShiftController@create')->name('v1.shift.create');

    });



});