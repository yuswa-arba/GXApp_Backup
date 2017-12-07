<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:13 AM
 */

namespace App\Attendance\Logics;


use Illuminate\Http\Request;

abstract class GetCalendarUseCase
{
    public static function getData(Request $request)
    {
        return (new static)->handle($request);
    }

    abstract public function handle($request);

}