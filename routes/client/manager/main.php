<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 31/10/17
 * Time: 6:16 PM
 */

use Illuminate\Support\Facades\Route;

Route::namespace('Client\Manager')->prefix('manager')->group(function () {

    Route::get('/timesheet/edit', 'ViewController@editTimesheet')->name('manager.editTimesheet');

});