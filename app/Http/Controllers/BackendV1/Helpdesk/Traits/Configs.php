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

    public static $TIMESHEET_NOTES_INITIAL = [
        'DAY-OFF' => 'D',
        'PAID-LEAVE' => 'PL',
        'ABSENCE'=>'A'
    ];

    public static $SALARY_FORMULA_OPEARTOR = [
        'SALARY' => '_salary_',
        'MIN_LATE_IN' =>'_min_late_in_',
        'MIN_EARLY_OUT'=>'_min_early_out_',
        'MIN_LATE_OUT'=>'_min_late_out_',
        'DAY_ABSENCE' =>'_day_absence_'
    ];

    public static $GENERATED_PAYROLL_TYPE = [
        'CONFIRMED' =>'confirmed',
        'STAGE_1_CONFIRMED'=>'stage-1-confirmed'
    ];

}