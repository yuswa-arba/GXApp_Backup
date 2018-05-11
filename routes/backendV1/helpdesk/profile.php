<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 28/12/17
 * Time: 3:14 PM
 */

use Illuminate\Support\Facades\Route;

Route::prefix('v1/h')->group(function () {
//    Route::prefix('attendance')->namespace('BackendV1\Helpdesk\Developer')->middleware('auth.admin')->group(function (){
    Route::prefix('profile')->namespace('BackendV1\Helpdesk\Profile')->middleware('auth')->group(function () {

        Route::get('user/employee/id','UserController@getEmployeeId')->name('v1.profile.user.employeeId');
        Route::get('user/detail','UserController@detail')->name('v1.user');
        Route::post('user/change/password','UserController@changePassword')->name('v1.profile.user.changePwd');

        Route::get('notification/list','NotificationController@getNotificationList')->name('v1.profile.notification.list');
        Route::get('notification/listOf','NotificationController@getNotificationListOfGroupType')->name('v1.profile.notification.listOf');
        Route::get('notification/seenAll','NotificationController@seenAllNotification')->name('v1.profile.notification.seenAll');
        Route::get('notification/seen','NotificationController@seenNotification')->name('v1.profile.notification.seen');
        Route::get('notification/recipient/groupTypes','NotificationController@getRecipientGroups')->name('v1.profile.notification.recipients');

    });

});