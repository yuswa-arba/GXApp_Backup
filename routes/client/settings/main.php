<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 6/11/17
 * Time: 2:12 PM
 */

use Illuminate\Support\Facades\Route;




/*
 |--------------------------------------------------------------------------
 | Setting Route
 |--------------------------------------------------------------------------
 */


Route::prefix('setting')->namespace('Client\Settings')->middleware('auth.admin')->group(function () {
    /*
     |--------------------------------------------------------------------------
     | Path Configuration
     |--------------------------------------------------------------------------
     */
    $client_path = 'routes/client/';
    $client_setting_path = $client_path.'settings/';

    $backend_path = 'routes/backendV1/';

    /*
     |--------------------------------------------------------------------------
     | Init setting routes
     |--------------------------------------------------------------------------
     */
    include (base_path($client_setting_path .'permission.php'));
});
