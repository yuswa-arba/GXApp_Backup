<?php

namespace App\Http\Controllers\BackendV1\API\Traits;

class ConfigCodes
{

    public static $LAST_ACTIVITY_TYPE = [
        'UNDEFINED' => 0,
        'CLOCKED_IN' => 1,
        'CLOCKED_OUT' => 2,
    ];

    public static $CLOCK_VIA_TYPE_ID = [
        'BY_KIOSK' => 1,
        'BY_PERSONAL_DEVICE' => 2,
        'BY_WEB_PORTAL' => 3
    ];

    public static $SUM_TYPE = [
        'ALL' => 'all',
        'EMPLOYEE' => 'employee',
        'DIVISION' => 'division'
    ];

    //@depreciated TO REMOVE
    public static $TOKEN_TYPE = [
        'ANDROID' => 'android',
        'WEB' => 'web'
    ];

    /* Use to tell android client where to send the users intent page
        when they click the push notification
    */
    public static $FCM_INTENT_TYPE = [
        'DEFAULT' => 'home',
        'HOME' => 'home',
        'SALARY' => 'salary',
        'PROFILE' => 'profile'
    ];

    public static $NOTIFY_TYPE = [
        'NOTIFICATION' => 'notification',
        'SMS' => 'sms'
    ];

    public static $EXCHANGE_SHIFT_CONFIRM_TYPE = [
        'WAITING' => 0,
        'CONFIRM' => 1,
        'DECLINE' => 2,
        'INVALID' => 3
    ];

    public static $EXCHANGE_ANSWER_TYPE = [
        'DECLINE' => 'decline',
        'ACCEPT' => 'accept'
    ];

    public static $REQUISITION_APPROVAL_STATUS = [
        'APPROVED' => 1,
        'DECLINED' => 2,
        'WAITING' => 3,
        'IN_PROCESS' => 4,
        'FINISH' => 5
    ];

    public static $PURCHASE_ORDER_STATUS = [
        'OPEN' => 1,
        'CLOSED' => 2,
        'PENDING' => 3,
        'CANCELED' => 4
    ];

    public static $LEAVE_APPROVAL = [
        'APPROVED' => 1,
        'DISAPPROVED' => 2,
        'WAITING_FOR_APPROVAL' => 3,
        'CHANGE_DATE' => 4,
        'POSTPONED' => 5
    ];


}