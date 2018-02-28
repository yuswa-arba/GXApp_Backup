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
//    Route::prefix('attendance')->namespace('BackendV1\Helpdesk\Attendance')->middleware('auth.admin')->group(function (){
    Route::prefix('component')->namespace('BackendV1\Helpdesk\Component')->group(function () {

        Route::get('religion/{id}','GetListController@religion')->name('v1.component.religion');
        Route::get('list/religion', 'GetListController@religions')->name('v1.component.list.religions');

        Route::get('jobPosition/{id}','GetListController@jobPosition')->name('v1.component.jobPosition');
        Route::get('list/jobPosition', 'GetListController@jobPositions')->name('v1.component.list.jobPositions');

        Route::get('slotMaker/{id}','GetListController@slotMaker')->name('v1.component.slotMaker');
        Route::get('list/slotMakers', 'GetListController@slotMakers')->name('v1.component.list.slotMakers');

        Route::get('slot/{id}','GetListController@slot')->name('v1.component.slot');
        Route::get('list/slots', 'GetListController@slots')->name('v1.component.list.slots');

        Route::get('shift/{id}','GetListController@shift')->name('v1.component.shift');
        Route::get('list/shifts', 'GetListController@shifts')->name('v1.component.list.shifts');

        Route::get('kiosk/{id}','GetListController@kiosk')->name('v1.component.kiosk');
        Route::get('list/kiosks', 'GetListController@kiosks')->name('v1.component.list.kiosks');

        Route::get('division/{id}','GetListController@division')->name('v1.component.division');
        Route::get('list/divisions', 'GetListController@divisions')->name('v1.component.list.divisions');

        Route::get('branchOffice/{id}','GetListController@branchOffice')->name('v1.component.branchOffice');
        Route::get('list/branchOffices', 'GetListController@branchOffices')->name('v1.component.list.branchOffices');

        Route::get('attdApproval/{id}','GetListController@attdApproval')->name('v1.component.attdApproval');
        Route::get('list/attdApprovals','GetListController@attdApprovals')->name('v1.component.list.attdApprovals');

        Route::get('leaveApproval/{id}','GetListController@leaveApproval')->name('v1.component.leaveApproval');
        Route::get('list/leaveApprovals','GetListController@leaveApprovals')->name('v1.component.list.leaveApprovals');

        Route::get('leaveType/{id}','GetListController@leaveType')->name('v1.component.leaveType');
        Route::get('list/leaveTypes','GetListController@leaveTypes')->name('v1.component.list.leaveTypes');

        Route::get('notificationGroupType/{id}','GetListController@notificationGroupType')->name('v1.component.notificationGroupType');
        Route::get('list/notificationGroupTypes','GetListController@notificationGroupTypes')->name('v1.component.list.notificationGroupTypes');

        Route::get('list/months','GetListController@months')->name('v1.component.list.months');

        Route::get('list/unitOfMeasurementTypes','GetListController@unitOfMeasurementTypes')->name('v1.component.unitOfMeasurementTypes');

        Route::get('list/countries','GetListController@countries')->name('v1.component.countries');

    });

});