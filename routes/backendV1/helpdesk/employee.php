<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 3/11/17
 * Time: 4:27 PM
 */


use Illuminate\Support\Facades\Route;


/* v1/h = version 1 Helpdesk API */
Route::prefix('v1/h')->group(function () {


    Route::prefix('employee')->namespace('BackendV1\Helpdesk\Employee')->middleware('auth.admin')->group(function () {

//        Route::post('create','RecruitmentController@create')->middleware('can:create')->name('v1.recruitment.create'); // using employe policy
//        Route::post('create','RecruitmentController@create')->name('v1.recruitment.create');
        Route::post('create', 'RecruitmentController@createEmployee')->name('v1.recruitment.create');
        Route::post('employment', 'RecruitmentController@submitEmployment')->name('v1.recruitment.employment');
        Route::post('resignation', 'ResignationController@resign')->name('v1.resignation');
        Route::post('upload', 'RecruitmentController@uploadImage')->name('v1.recruitment.upload');
        Route::get('search/{searchText}', 'ListController@searchEmployee')->name('v1.list.search');

        Route::get('list', 'ListController@mainList');
        Route::get('list/resigned', 'ListController@resignedList');
        Route::get('detail/master/{id}', 'AjaxController@masterEmployeeDetail');
        Route::get('detail/faceapi/{employeeId}', 'AjaxController@faceAPIDetail');
        Route::get('detail/employment/{employeeId}', 'AjaxController@employmentDetail');
        Route::get('detail/login/{employeeId}', 'AjaxController@loginDetail');
        Route::get('detail/resignation/{employeeId}', 'AjaxController@resignationDetail');

        Route::get('edit/master/{id}', 'AjaxController@masterEmployeeEdit');
        Route::post('edit/master', 'AjaxController@saveMasterEmployeeEdit');

        Route::get('edit/employment/{employeeId}', 'AjaxController@employmentEdit');
        Route::post('edit/employment', 'AjaxController@saveEmploymentEdit');

        Route::get('edit/login/{employeeId}', 'AjaxController@loginEdit');
        Route::post('edit/login', 'AjaxController@saveLoginEdit');

        Route::post('edit/faceapi/person', 'AjaxController@saveFaceApiPerson');
        Route::post('edit/faceapi/personFace', 'AjaxController@saveFaceApiPersonFace');
        Route::post('edit/faceapi/savePhoto', 'AjaxController@saveFacePhoto');
        Route::delete('edit/faceapi/deletePhoto/{persistedFaceId}', 'AjaxController@deleteFacePhoto');
    });

});