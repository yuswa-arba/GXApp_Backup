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
Route::prefix('bv1/setting')->namespace('BackendV1\Settings')->middleware('auth.admin')->group(function () {
    /*
     |--------------------------------------------------------------------------
     | Path Configuration
     |--------------------------------------------------------------------------
     */

    $backend_path = 'routes/backendV1/';
    $backend_setting_path = $backend_path.'settings/';

    /*
     |--------------------------------------------------------------------------
     | Init setting routes
     |--------------------------------------------------------------------------
     */
    include (base_path($backend_setting_path .'permission.php'));
});
