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

        // Kisosk
        Route::middleware('client')->group(function () {

            /* @header Authorization Bearer <kiosk_api_token> * */

            /*
             * @param punchType in/out
             * @body cViaTypeId int
             * @body employeeId uuid
             * @body isMicrosoftFaceAPIApproved string yes/no
             * */
            Route::post('clock/{punchType}', 'MainController@clock');

            /*
             * @param punchType in/out
             * @body cViaTypeId int
             * @body employeeId uuid
             * @body dDate string dd/mm/yyy
             * @body cTime string H:i
             * @body isMicrosoftFaceAPIApproved string yes/no
             * */
            Route::post('clock/backup/{punchType}','MainController@clockBackUp'); //clock in / clock out for backup sync

        });


        Route::middleware('auth:api')->group(function () {

            Route::get('calendar/detail', 'CalendarController@detail');

            Route::get('shift/exchange/checkDate', 'ShiftController@attemptCheckDate');
            Route::get('shift/exchange/attempt/workday', 'ShiftController@attemptExchangeWorkingDay');
            Route::get('shift/exchange/attempt/pubHoliday','ShiftController@attemptExchangePublicHoliday');
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

            /*
             * @param id
             */
            Route::get('detail/{id}', 'KioskController@detail');

            /*
             * @param id
             */
            Route::get('save/heartbeat/{kioskId}','KioskController@saveLastHeartBeat');

            /*
             * @param kioskId
             * @body batteryPower
             * @body isCharging
             */
            Route::post('save/battery/{kioskId}','KioskController@saveBatteryStatus');

            /*
             * @param kioskId
             * @body totalSynced
             * @body totalUnsynced
             */
            Route::post('save/localStorage/{kioskId}','KioskController@saveLocalStorageData');

            /*
            * @param kioskId
            * @body logs
            */
            Route::post('log/unsynced/{kioskId}','KioskController@logUnsyncedData');

            /*
             * @param personGroupId
             * @param personId
             */
            Route::get('employee/pg/{personGroupId}/person/{personId}/activity', 'KioskController@getEmployeeActivity');

            /*
             * @param employeeNo string
             */
            Route::get('employee/no/{employeeNo}/activity','KioskController@getEmployeeActivityByEmployeeNo');

            /*
             * @param employeeId uuid
             */
            Route::get('employee/setting/access/{employeeId}', 'KioskController@getEmployeeAccess');

            /*
             * @body kioskId int
             * @body passcode string
             */
            Route::post('setting/access', 'KioskController@checkKioskPasscode');

        });
    });

});
