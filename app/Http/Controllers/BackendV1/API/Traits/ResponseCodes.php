<?php

namespace App\Http\Controllers\BackendV1\API\Traits;

class ResponseCodes
{

    public static $SUCCEED_CODE = [
        'SUCCESS' => 1
    ];

    public static $ERR_CODE = [
        'UNKNOWN' => 100000,
        'ELOQUENT_ERR' => 100001,
        'MISSING_PARAM' => 100002,
    ];

    public static $KIOSK_ERR_CODES = [
        'KIOSK_NOT_FOUND' => 300001,
        'PASSCODE_NOT_MATCH' => 300002,
        'ACCESS_TOKEN_MISSING' => 300003,
        'INVALID_TOKEN' => 300004,
        'HAS_BEEN_ACTIVATED' => 300005,
        'ACTIVATION_CODE_MISMATCH' => 300005,
        'UNDEFINED_PUNCH_TYPE' => 300006,
        'EMPLOYEE_NOT_FOUND' => 300007,
        'PERSON DATA NOT FOUND' => 300008,
        'USER NOT FOUND' => 300009,
        'UNAUTHORIZED_ACCESS' => 300010
    ];

    public static $USER_ERR_CODE = [
        'USER_NOT_FOUND' => 400001,
        'USER_ACCESS_NOT_GRANTED' => 400002,
        'USER_EMPLOYEE_DATA_NOT_FOUND' => 400003,
        'EMPLOYMENT_NOT_FOUND'=>400004
    ];

    public static $ATTD_ERR_CODES = [
        'ALREADY_CLOCKED_IN' => 500001,
        'ALREADY_CLOCKED_OUT' => 500002,
        'NOT_ALLOWED_TO_CLOCK_IN' => 500003,
        'NOT_ALLOWED_TO_CLOCK_OUT' => 500004,
        'UNDEFINED_PUNCH_TYPE' => 500005,
        'EMPLOYEE_NOT_FOUND' => 500006,
        'IS_DAY_OFF' => 500007,
        'JOB_POSITION_ID_NOT_DEFINED' => 500008,
        'UNDEFINED_EXCHANGE_CONFIRMATION_TYPE' => 500009,
        'UNAUTHORIZED_TO_ANSWER_EXCHANGE' => 500010,
        'UNABLE_TO_GET_EXCHANGE_SHIFTS_DATA' => 500011,
        'REQUIRED_EXCHANGE_TO_DATE' => 500012,
        '3_DAYS_BEFORE_EXCHANGE_DAY_OFF' => 500013,
        'UNABLE_TO_CHANGE_PAST_DATES' => 500014,
        'EXCHANGE_SHIFT_DATA_NOT_FOUND' => 500015,
        'INVALID_EXCHANGE_REQUEST' => 500016,
        'TIMESHEET_HISTORY_RECORD_NOT_FOUND' => 500017,
        'PUBLIC_HOLIDAY_SCHEDULE_UNDEFINED' => 500018,
        'UNDEFINED_SHIFT_ID' => 500019,
        'IS_PUBLIC_HOLIDAY' => 500020,
        'REACHED_MAXIMUM_PAID_LEAVE'=>500021,
        'HAS_USED_CHANCE_TO_STREAK_PAID_LEAVE' =>500022,
        'ALREADY_HAS_PAID_LEAVE_IN_CURRENT_MONTH'=>500023,
        'IS_YOUR_PAID_LEAVE' => 5000024,
        'NOT_ELIGIBLE_FOR_PAID_LEAVE'=>5000025,
        'STREAK_PAID_LEAVE_MORE_THAN_7'=>5000026,
        'INVALID_DATE'=>5000027,
        'NO_PAID_LEAVE_DATA'=>5000028,
        'UNABLE_TO_REMOVE_REQUEST'=>5000029
    ];

    public static $SALARY_ERR_CODES = [
        'SALARY_REPORT_NOT_FOUND' => 600001,
        'CONFIRM_TYPE_UNDEFINED' => 600002,
    ];

    public static $PROFILE_ERR_CODE = [
        'CONFIRMATION_DOESNT_MATCH' => 700001,
        'OLD_PASSWORD_INCORRECT' => 700002
    ];

    public static $APK_ERR_CODE = [
        'APK_NOT_FOUND'=>800001
    ];

    public static $HTTP_CODES = [
        'SUCCESS' => 200,
        'FORBIDDEN' => 403,
        'NOT_FOUND' => 404,
        'BAD_PARAM' => 422,
        'SERVER_ERROR' => 500
    ];


}