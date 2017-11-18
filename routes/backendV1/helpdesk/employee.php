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
        Route::post('employment','RecruitmentController@submitEmployment')->name('v1.recruitment.employment');
        Route::post('upload','RecruitmentController@uploadImage')->name('v1.recruitment.upload');

        Route::get('list','ListController@mainList');
        Route::get('detail/master/{id}','AjaxController@masterEmploymentDetail');
        Route::get('detail/employment/{employeeId}','AjaxController@employmentDetail');
        Route::get('detail/login/{employeeId}','AjaxController@loginDetail');

        Route::get('edit/master/{id}','AjaxController@masterEmploymentEdit');
        Route::post('edit/master','AjaxController@saveMasterEmploymentEdit');

        Route::get('edit/employment/{employeeId}','AjaxController@employmentEdit');
        Route::post('edit/employment','AjaxController@saveEmploymentEdit');

        Route::get('edit/login/{employeeId}','AjaxController@loginEdit');
        Route::post('edit/login','AjaxController@saveLoginEdit');
    });

});