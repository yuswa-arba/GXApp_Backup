<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 28/12/17
 * Time: 3:14 PM
 */

use Illuminate\Support\Facades\Route;

Route::prefix('v1/h')->group(function () {
//    Route::prefix('attendance')->namespace('BackendV1\Helpdesk\Developer')->middleware('auth.admin')->group(function (){
    Route::prefix('developer')->namespace('BackendV1\Helpdesk\Developer')->group(function () {

        Route::get('log/list','LogController@getList')->name('v1.developer.log');

        Route::get('queue/job/list','QueueJobController@getDataJobs');
        Route::get('queue/failedJob/list','QueueJobController@getDataFailedJobs');
        Route::get('queue/retry/job','QueueJobController@retryJob');
        Route::get('queue/delete/job','QueueJobController@deleteJobs');
        Route::get('queue/retry/failedJob','QueueJobController@retryFailedJob');
        Route::get('queue/delete/failedJob','QueueJobController@deleteFailedJobs');

        Route::get('report/problem/list','ReportProblemController@getList');
        Route::post('report/problem/submit','ReportProblemController@submit');
        Route::post('report/problem/update','ReportProblemController@update');


        Route::get('backup/create','BackupController@create');
        Route::get('backup/download/{file_name?}','BackupController@download');
        Route::get('backup/delete/{file_name?}','BackupController@delete')->where('file_name', '(.*)');

        Route::get('fingerspot/list','FingerspotController@getList');
        Route::post('fingerspot/submit','FingerspotController@submit');
        Route::post('fingerspot/update','FingerspotController@update');

    });
});