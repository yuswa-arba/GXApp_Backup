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
        Route::post('slotMaker/repeat','SlotMakerController@repeat')->name('v1.slotMaker.repeat');
        Route::post('slotMaker/autoAssign','SlotMakerController@autoAssign')->name('v1.slotMaker.autoAssign');

        Route::get('slot/list','SlotController@list')->name('v1.slot.list');
        Route::get('slot/detail/calendar','SlotController@calendar')->name('v1.slot.calendar');
        Route::get('slot/assign/employee','SlotController@employeeList')->name('v1.slot.assign.get.employee');
        Route::post('slot/assign/employee','SlotController@assign')->name('v1.slot.assign.employee');
        Route::post('slot/remove/employee','SlotController@remove')->name('v1.slot.remove.employee');
        Route::post('slot/edit/useMapping','SlotController@editShiftOption')->name('v1.slot.edit.useMapping');
        Route::post('slot/delete','SlotController@delete')->name('v1.slot.delete');
        Route::post('slot/copy','SlotController@copySlot')->name('v1.slot.copySlot');

        Route::get('schedule','ScheduleController@getSchedule')->name('v1.schedule');
        Route::get('schedule/check','ScheduleController@checkSchedule')->name('v1.check.schedule');

        Route::post('shift/create','ShiftController@create')->name('v1.shift.create');
        Route::post('shift/delete','ShiftController@delete')->name('v1.shift.delete');

        Route::post('shift/mapping','ShiftController@mapping')->name('v1.shift.mapping');
        Route::post('shift/mapping/calendar','ShiftController@getMappingCalendar')->name('v1.shift.mapping.calendar');
        Route::post('shift/mapping/schedule','ShiftController@getShiftScheduleOnCalendar')->name('v1.shift.mapping.shiftSchedule');
        Route::post('shift/mapping/pubHolidays','ShiftController@getPubHolidayScheduleOnCalendar')->name('v1.shift.mapping.publicHoliday');
        Route::post('shift/remove/schedule','ShiftController@removeSchedule')->name('v1.shift.remove.schedule');
        Route::post('shift/edit/schedule','ShiftController@editSchedule')->name('v1.shift.edit.schedule');

        Route::post('kiosk/create','KioskController@create')->name('v1.kiosk.create');
        Route::post('kiosk/delete','KioskController@delete')->name('v1.kiosk.delete');
        Route::post('kiosk/edit','KioskController@edit')->name('v1.kiosk.edit');

        Route::get('timesheet/list','TimesheetController@list')->name('v1.timesheet.list');
        Route::get('timesheet/detail/{timesheetId}','TimesheetController@detail')->name('v1.timesheet.detail');
        Route::post('timesheet/approve','TimesheetController@approve')->name('v1.timesheet.approve');
        Route::post('timesheet/disapprove','TimesheetController@disapprove')->name('v1.timesheet.disapprove');
        Route::post('timesheet/update','TimesheetController@update')->name('v1.timesheet.update');
        Route::post('timesheet/createManually','TimesheetController@createManually')->name('v1.timesheet.createManually');
        Route::get('timesheet/summary/{sumType}','TimesheetController@summary')->name('v1.timesheet.summary');

        Route::get('leave/list','LeaveScheduleController@list')->name('v1.leave.list');

        Route::get('dashboard/livefeed','DashboardController@livefeed')->name('v1.timesheet.livefeed');

        Route::get('setting/list','SettingController@list')->name('v1.attendance.setting.list');
        Route::post('setting/edit','SettingController@edit')->name('v1.attendance.setting.edit');

        Route::get('pubHoliday/list','PublicHolidayController@getList')->name('v1.attendance.pubHoliday.list');
        Route::post('pubHoliday/create','PublicHolidayController@create')->name('v1.attendance.pubHoliday.create');
        Route::post('pubHoliday/delete','PublicHolidayController@delete')->name('v1.attendance.pubHoliday.delete');
        Route::post('pubHoliday/apply','PublicHolidayController@apply')->name('v1.attendance.pubHoliday.apply');

    });


});