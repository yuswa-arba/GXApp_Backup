<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Traits;

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 30/12/17
 * Time: 12:24 PM
 */
class Configs
{
    public static $IMAGE_PATH = [
        'ATTENDANCE_PHOTO' => 'public/images/attendances/',
        'FACES_PHOTO' => 'public/images/faces/',
        'EMPLOYEE_PHOTO' => 'public/images/employee/',
        'RESIGNATION_PHOTO' => 'public/images/resignation/',
    ];

    public static $PUNCH_TYPE = [
        'IN' => 'in',
        'OUT' => 'out'
    ];

}