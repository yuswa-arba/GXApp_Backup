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
    Route::prefix('setting')->namespace('BackendV1\Helpdesk\Settings')->group(function () {
        Route::get('role/list', 'Permission\MainController@roleList');
        Route::get('permission/list','Permission\MainController@permissionList');
        Route::get('user/list','Permission\MainController@userList');

        Route::post('role', 'Permission\MainController@createRole')->name('v1.role.create');
        Route::post('permission', 'Permission\MainController@createPermission')->name('v1.permission.create');

        Route::get('permission/assigned/{permissionName}', 'Permission\AjaxController@vdByPermission');
        Route::post('permission/assign/by_permission/role', 'Permission\AjaxController@assignByPermissionToRole');
        Route::post('permission/assign/by_permission/user', 'Permission\AjaxController@assignByPermissionToUser');


        Route::get('role/assigned/{roleName}', 'Permission\AjaxController@vdByRole');
        Route::post('role/assign/by_role', 'Permission\AjaxController@assignByRole');

        Route::get('user/assigned/{employeeId}', 'Permission\AjaxController@vdByuser');
        Route::post('user/assign/by_user', 'Permission\AjaxController@assignByUser');

        Route::post('notification/groupType/create','NotificationController@addGroupType');
    });
});