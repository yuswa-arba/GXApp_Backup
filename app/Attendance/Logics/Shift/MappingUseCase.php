<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:13 AM
 */

namespace App\Attendance\Logics\Shift;


use Illuminate\Http\Request;

abstract class MappingUseCase
{
    public static function mapping(Request $request)
    {
        return (new static)->handleMapping($request);
    }

    abstract public function handleMapping($request);

}