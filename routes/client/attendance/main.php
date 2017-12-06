<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 22/11/17
 * Time: 3:33 PM
 */

/*
 |--------------------------------------------------------------------------
 | Setting Route
 |--------------------------------------------------------------------------
 */


use Illuminate\Support\Facades\Route;

Route::prefix('attendance')->namespace('Client\Attendance')->middleware('auth.admin')->group(function () {


    Route::get('/', function(){
        // do something here or simply redirect
        return redirect()->route('attendance.dashboard');
    })->name('attendance');

    /*
     |--------------------------------------------------------------------------
     | Path Configuration
     |--------------------------------------------------------------------------
     */
    $client_path = 'routes/client/';
    $client_setting_path = $client_path.'attendance/';

    $backend_path = 'routes/backendV1/';

    /*
     |--------------------------------------------------------------------------
     | Init setting routes
     |--------------------------------------------------------------------------
     */
    include (base_path($client_setting_path .'dashboard.php'));
    include (base_path($client_setting_path .'slot.php'));
    include (base_path($client_setting_path .'setting.php'));

});
