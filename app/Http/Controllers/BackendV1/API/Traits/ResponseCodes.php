<?php

namespace App\Http\Controllers\BackendV1\API\Traits;

class ResponseCodes{

    public static $SUCCEED_CODE = [
        'SUCCESS'=>1
    ];

    public static $ERR_CODE = [
        'UNKNOWN'=>400000,
        'ELOQUENT_ERR' => 400001,
        'MISSING_PARAM' => 400002,
    ];

    public static $KIOSK_ERR_CODES = [
        'KIOSK_NOT_FOUND' => 300001,
        'PASSCODE_NOT_MATCH' => 300002,
        'ACCESS_TOKEN_MISSING' => 300003,
        'INVALID_TOKEN' => 300004,
        'HAS_BEEN_ACTIVATED' =>300005,
        'ACTIVATION_CODE_MISMATCH' =>300005,
        'UNDEFINED_PUNCH_TYPE' =>300006,
        'EMPLOYEE_NOT_FOUND'=>300007
    ];

    public static $HTTP_CODES = [
        'SUCCESS' =>200,
        'FORBIDDEN'=>403,
        'NOT_FOUND'=>404,
        'BAD_PARAM'=>422,
        'SERVER_ERROR'=>500
    ];


}