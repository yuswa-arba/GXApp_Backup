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
    Route::prefix('superAdmin')->namespace('BackendV1\Helpdesk\SuperAdmin')->group(function () {
        Route::post('login', 'AuthController@login')->name('submit.superAdmin.login');
        Route::post('employee/create', 'RecruitmentController@createEmployee')->name('v1.superadmin.recruitment.create');
        Route::post('employee/medicalRecords', 'RecruitmentController@submitMedicalRecords')->name('v1.superadmin.recruitment.medicalRecords');
        Route::post('employee/employment', 'RecruitmentController@submitEmployment')->name('v1.superadmin.recruitment.employment');
        Route::post('employee/upload', 'RecruitmentController@uploadImage')->name('v1.superadmin.recruitment.upload');
    });
});