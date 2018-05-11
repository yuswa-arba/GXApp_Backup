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

    Route::prefix('manager')->namespace('BackendV1\Helpdesk\Manager')->group(function () {

        Route::get('timesheet/list','EditTimesheetController@list');
        Route::get('timesheet/summary','EditTimesheetController@summary');
        Route::post('timesheet/generateAndSend','EditTimesheetController@generateAndSend');


    });

});