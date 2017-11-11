<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 6/11/17
 * Time: 5:12 PM
 */

use Illuminate\Support\Facades\Route;

Route::get('role/list', 'Permission\MainController@roleList');
Route::get('permission/list','Permission\MainController@permissionList');

Route::post('role', 'Permission\MainController@createRole')->name('v1.role.create');
Route::post('permission', 'Permission\MainController@createPermission')->name('v1.permission.create');

Route::get('permission/assigned/{permissionName}', 'Permission\AjaxController@vdByPermission');
Route::post('permission/assign/by_permission', 'Permission\AjaxController@assignByPermission');

Route::get('role/assigned/{roleName}', 'Permission\AjaxController@vdByRole');
Route::post('role/assign/by_role', 'Permission\AjaxController@assignByRole');
