<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 23/12/17
 * Time: 3:15 PM
 */

namespace App\Attendance\Logics\PublicHoliday;


use Illuminate\Http\Request;

abstract class ApplyPubHolidayUseCase
{
    public static function apply(Request $request)
    {
        return (new static)->handle($request);
    }

    abstract public function handle($request);
}