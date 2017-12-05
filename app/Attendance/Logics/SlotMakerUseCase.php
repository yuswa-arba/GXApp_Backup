<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:13 AM
 */

namespace App\Attendance\Logics;


use Illuminate\Http\Request;

abstract class SlotMakerUseCase
{
    public static function executeSlotMaker(Request $request)
    {
        return (new static)->handleExecution($request);
    }

    abstract public function handleExecution($request);

}