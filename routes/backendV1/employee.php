<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 3/11/17
 * Time: 4:27 PM
 */


use Illuminate\Support\Facades\Route;



Route::prefix('v1')->group(function (){

    Route::namespace('BackendV1\Employee')->prefix('employee')->middleware('auth.admin')->group(function (){

        Route::post('create','RecruitmentController@create')->middleware('can:create')->name('v1.recruitment.create');

    });

});