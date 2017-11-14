<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 3/11/17
 * Time: 4:27 PM
 */


use Illuminate\Support\Facades\Route;


/* v1/h = version 1 Helpdesk API */
Route::prefix('v1/h')->group(function (){
    Route::prefix('employee')->namespace('BackendV1\Helpdesk\Employee')->middleware('auth.admin')->group(function (){

//        Route::post('create','RecruitmentController@create')->middleware('can:create')->name('v1.recruitment.create'); // using employe policy
//        Route::post('create','RecruitmentController@create')->name('v1.recruitment.create');
        Route::post('create','RecruitmentController@createEmployee')->name('v1.recruitment.create');
        Route::get('employment','RecruitmentController@submitEmployment')->name('v1.recruitment.employment');
        Route::post('upload','RecruitmentController@uploadImage')->name('v1.recruitment.upload');
    });

});