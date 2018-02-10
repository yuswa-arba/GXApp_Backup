<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 19/12/17
 * Time: 8:32 AM
 */

/* v1/a = version 1 Android API */
use Illuminate\Support\Facades\Route;

Route::prefix('v1/a')->group(function () {

    /*Attendance*/
    Route::namespace('BackendV1\API\Attendance')->prefix('attd')->group(function () {

        // kiosk
        Route::middleware('client')->group(function () {

            Route::post('clock/{punchType}', 'MainController@clock'); // clock in / clock out

        });


        Route::middleware('auth:api')->group(function () {

            Route::get('calendar/detail', 'CalendarController@detail');

            Route::get('shift/exchange/checkDate', 'ShiftController@attemptCheckDate');
            Route::get('shift/exchange/attempt/workday', 'ShiftController@attemptExchangeWorkingDay');
            Route::get('shift/exchange/attempt/dayoff', 'ShiftController@attemptExchangeDayOff');
            Route::post('shift/exchange/request','ShiftController@requestExchange');
            Route::post('shift/exchange/answer','ShiftController@answerExchange');
            Route::get('shift/exchange/list/outgoing','ShiftController@outgoingExchangeList');
            Route::get('shift/exchange/list/incoming','ShiftController@incomingExchangeList');

            Route::get('history/record','HistoryController@getRecord');

        });
    });

    /*Kiosk Authentication using passport client_credentials grant type*/
    Route::namespace('BackendV1\API\Attendance')->prefix('kiosk/auth')->group(function () {

        Route::post('login', 'KioskAuthController@login');
        Route::get('getApiToken', 'KioskAuthController@getApiToken');
        Route::post('activate', 'KioskAuthController@activateKiosk');

        Route::middleware('client')->group(function () {

            Route::post('logout', 'KioskAuthController@logout');
            Route::get('test', 'KioskAuthController@test');

        });
    });

    /*Kiosk*/
    Route::namespace('BackendV1\API\Attendance')->prefix('kiosk')->group(function () {
        Route::middleware('client')->group(function () {
            /* @header Authorization Bearer <kiosk_api_token> * */

            /*
             * @param punchType in/out
             * @body cViaTypeId int
             * @body employeeId uuid
             * */
            Route::post('clock/{punchType}', 'MainController@clock');

            /*
             * @param id
             * */
            Route::get('detail/{id}', 'KioskController@detail');

            Route::get('employee/pg/{personGroupId}/person/{personId}/activity', 'KioskController@getEmployeeActivity');

            Route::get('employee/setting/access/{employeeId}', 'KioskController@getEmployeeAccess');

            Route::post('setting/access', 'KioskController@checkKioskPasscode');

        });
    });

});
