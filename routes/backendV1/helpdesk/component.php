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

        Route::get('list/jobPosition', 'GetListController@jobPosition')->name('v1.component.list.jobPosition');

    });

});