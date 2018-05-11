<?php

namespace App\Traits;

class GlobalConfig
{

    public static $PURCHASE_ORDER_INFO = [
        'SIGNATURE_NAME' => 'Cindie Marcella',
        'POSITION' => 'CHIEF FINANCE OFFICER',
        'SIGNATURE_IMG' => 'images/company/signature/cindie-marcella-signature.png',
    ];

    public static $ELIGIBLE_DAYS_FOR_PAID_LEAVE = [
        'DAYS' => 520, //2 years working days
        'YEARS' => 2
    ];

    public static $MICROSOFT_FACE_API = [
        'BASE_URL' => 'https://southeastasia.api.cognitive.microsoft.com/face/v1.0/',
        'SUB_KEY' => 'e498335112c8402a82967303033da0a4',
        'PERSON_GROUP_ID' => 'gx_development'
    ];

    public static $BACKEND_PATH_V1 = [
        'HELPDESK'=>'/v1/h/',
        'API' =>'/api/v1/a/'
    ];


}