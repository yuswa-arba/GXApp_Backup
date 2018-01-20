<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:13 AM
 */

namespace App\Attendance\Logics\Shift;


use Illuminate\Http\Request;

abstract class GetShiftCalendarUseCase
{
    public static function getDayOffs(Request $request){
        return (new static)->handleDayOffs($request);
    }

    public static function getShiftSchedules(Request $request){
        return (new static)->handleShiftSchedules($request);
    }

    abstract public function handleDayOffs($request);
    abstract public function handleShiftSchedules($request);

}