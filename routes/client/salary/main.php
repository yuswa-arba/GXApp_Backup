<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 22/11/17
 * Time: 3:33 PM
 */

/*
 |--------------------------------------------------------------------------
 | Salary Route
 | Only give access to specific user
 |--------------------------------------------------------------------------
 */


use Illuminate\Support\Facades\Route;

Route::prefix('salary')->namespace('Client\Salary')->group(function () {


    Route::get('/', function(){
        // do something here or simply redirect
        return redirect()->route('salary.report');
    })->name('salary');

    Route::get('report/', 'ViewController@report')->name('salary.report');
    Route::get('employee/', 'ViewController@employee')->name('salary.employee');
    Route::get('setting/', 'ViewController@setting')->name('salary.setting');
    Route::get('payroll/','ViewController@payroll')->name('salary.payroll');

});
