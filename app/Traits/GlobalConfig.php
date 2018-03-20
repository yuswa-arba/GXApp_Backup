<?php

namespace App\Traits;

class GlobalConfig
{

    public static $PURCHASE_ORDER_INFO = [
        'SIGNATURE_NAME' => 'Cindie Marcella',
        'POSITION' => 'CHIEF FINANCE OFFICER',
        'SIGNATURE_IMG' => 'images/company/signature/cindie-marcella-signature.png',
    ];

    public static $MAX_PAID_LEAVE = [
      'DAYS'=>12
    ];

    public static $MAX_STREAK_PAID_LEAVE = [
        'DAYS'=>7
    ];

    public static $ELIGIBLE_DAYS_FOR_PAID_LEAVE = [
        'DAYS'=>520, //2 years working days
        'YEARS'=>2
    ];
}