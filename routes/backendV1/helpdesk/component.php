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
    Route::prefix('component')->namespace('BackendV1\Helpdesk\Component')->group(function () {

        Route::get('jobPosition/{id}','GetListController@jobPosition')->name('v1.component.list.jobPosition');
        Route::get('list/jobPosition', 'GetListController@jobPositions')->name('v1.component.list.jobPositions');

        Route::get('slot/{id}','GetListController@slot')->name('v1.component.list.slot');
        Route::get('list/slots', 'GetListController@slots')->name('v1.component.list.slots');

        Route::get('shift/{id}','GetListController@shift')->name('v1.component.list.shift');
        Route::get('list/shifts', 'GetListController@shifts')->name('v1.component.list.shifts');

    });

});