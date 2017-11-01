<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 31/10/17
 * Time: 6:16 PM
 */

use Illuminate\Support\Facades\Route;

Route::prefix('employee')->group(function () {

    Route::get('/', function () {
        // permission validation can be put here or simply redirect
        return redirect()->route('employeeList');

    })->name('employee');

    Route::get('list', 'Employee\ViewController@index')->name('employeeList');
    Route::get('recruitment', 'Employee\ViewController@recruitment')->name('employeeRecruitmentForm');
});