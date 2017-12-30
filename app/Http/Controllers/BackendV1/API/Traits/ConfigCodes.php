<?php

namespace App\Http\Controllers\BackendV1\API\Traits;

class ConfigCodes{

    public static $LAST_ACTIVITY_TYPE = [
        'UNDEFINED'=>0,
        'CLOCKED_IN'=>1,
        'CLOCKED_OUT'=>2,
    ];

    public static $CLOCK_VIA_TYPE_ID = [
        'BY_KIOSK'=>1,
        'BY_PERSONAL_DEVICE'=>2,
        'BY_WEB_PORTAL'=>3
    ];




}