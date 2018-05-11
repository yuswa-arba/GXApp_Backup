<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 2/11/17
 * Time: 12:22 PM
 */

use Illuminate\Support\Facades\Route;

/* v1/a = version 1 Android API */
Route::prefix('v1/a')->group(function () {

    Route::namespace('BackendV1\API\Misc')->prefix('misc')->group(function () {

        Route::middleware('auth:api')->group(function () {

            Route::get('report/problem/list','ReportProblemController@getList');
            Route::post('report/problem/submit','ReportProblemController@submit');
            Route::post('report/problem/update','ReportProblemController@update');

        });

    });

});