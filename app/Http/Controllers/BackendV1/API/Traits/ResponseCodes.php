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
        'UNAUTHORIZED_ACCESS'=>300010
    ];

    public static $USER_ERR_CODE = [
        'USER_NOT_FOUND'=>400001,
        'USER_ACCESS_NOT_GRANTED'=>400002,
        'USER_EMPLOYEE_DATA_NOT_FOUND'=>400003
    ];

    public static $ATTD_ERR_CODES = [
        'ALREADY_CLOCKED_IN' => 500001,
        'ALREADY_CLOCKED_OUT' => 500002,
        'NOT_ALLOWED_TO_CLOCK_IN' => 500003,
        'NOT_ALLOWED_TO_CLOCK_OUT'=>500004,
        'UNDEFINED_PUNCH_TYPE' => 500005,
        'EMPLOYEE_NOT_FOUND' => 500006,
        'IS_DAY_OFF'=>500007,
        'JOB_POSITION_ID_NOT_DEFINED'=>500008,
        'UNDEFINED_EXCHANGE_CONFIRMATION_TYPE'=>500009,
        'UNAUTHORIZED_TO_ANSWER_EXCHANGE'=>500010,
        'UNABLE_TO_GET_EXCHANGE_SHIFTS_DATA'=>500011,
        'REQUIRED_EXCHANGE_TO_DATE'=>500012,
        '3_DAYS_BEFORE_EXCHANGE_DAY_OFF'=>500013,
        'UNABLE_TO_CHANGE_PAST_DATES'=>500014,
        'EXCHANGE_SHIFT_DATA_NOT_FOUND'=>500015
    ];

    public static $SALARY_ERR_CODES = [
        'SALARY_REPORT_NOT_FOUND' =>600001,
        'CONFIRM_TYPE_UNDEFINED'=>600002,
    ];

    public static $PROFILE_ERR_CODE =[
        'CONFIRMATION_DOESNT_MATCH'=>700001,
        'OLD_PASSWORD_INCORRECT'=>700002
    ];


    public static $HTTP_CODES = [
        'SUCCESS' => 200,
        'FORBIDDEN' => 403,
        'NOT_FOUND' => 404,
        'BAD_PARAM' => 422,
        'SERVER_ERROR' => 500
    ];


}