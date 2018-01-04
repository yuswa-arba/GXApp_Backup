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
        Route::post('slot/edit/useMapping','SlotController@editShiftOption')->name('v1.slot.edit.useMapping');

        Route::post('shift/create','ShiftController@create')->name('v1.shift.create');
        Route::post('shift/delete','ShiftController@delete')->name('v1.shift.delete');

        Route::post('shift/mapping','ShiftController@mapping')->name('v1.shift.mapping');
        Route::post('shift/mapping/calendar','ShiftController@getMappingCalendar')->name('v1.shift.mapping.calendar');
        Route::post('shift/mapping/schedule','ShiftController@getShiftScheduleOnCalendar')->name('v1.shift.mapping.shiftSchedule');
        Route::post('shift/remove/schedule','ShiftController@removeSchedule')->name('v1.shift.remove.schedule');
        Route::post('shift/edit/schedule','ShiftController@editSchedule')->name('v1.shift.edit.schedule');

        Route::post('kiosk/create','KioskController@create')->name('v1.kiosk.create');
        Route::post('kiosk/delete','KioskController@delete')->name('v1.kiosk.delete');

        Route::get('timesheet/list','TimesheetController@list')->name('v1.timesheet.list');
        Route::get('timesheet/detail/{timesheetId}','TimesheetController@detail')->name('v1.timesheet.detail');
        Route::post('timesheet/approve','TimesheetController@approve')->name('v1.timesheet.approve');
        Route::post('timesheet/disapprove','TimesheetController@disapprove')->name('v1.timesheet.disapprove');
        Route::get('timesheet/summary/{sumType}','TimesheetController@summary')->name('v1.timesheet.summary');

    });


});