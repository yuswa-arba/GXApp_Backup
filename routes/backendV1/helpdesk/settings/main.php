<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 6/11/17
 * Time: 4:50 PM
 */


/*
 |--------------------------------------------------------------------------
 | Setting Route
 |--------------------------------------------------------------------------
 */


use Illuminate\Support\Facades\Route;

//Route::prefix('v1/setting')->namespace('BackendV1\Settings')->middleware('auth.admin:api')->group(function () {
Route::prefix('v1/h')->group(function () {
    Route::prefix('setting')->namespace('BackendV1\Helpdesk\Settings')->group(function () {
        /*
         |--------------------------------------------------------------------------
         | Path Configuration
         |--------------------------------------------------------------------------
         */

        $backend_path = 'routes/backendV1/helpdesk/';
        $backend_setting_path = $backend_path . 'settings/';

        /*
         |--------------------------------------------------------------------------
         | Init setting routes
         |--------------------------------------------------------------------------
         */
        include(base_path($backend_setting_path . 'permission.php'));
    });
});