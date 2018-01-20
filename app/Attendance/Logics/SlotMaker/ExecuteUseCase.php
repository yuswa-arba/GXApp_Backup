<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:13 AM
 */

namespace App\Attendance\Logics\SlotMaker;


use Illuminate\Http\Request;

abstract class ExecuteUseCase
{
    public static function execute(Request $request)
    {
        return (new static)->handleExecution($request);
    }

    public static function repeat(Request $request){
        return (new static)->handleRepeat($request);
    }

    abstract public function handleExecution($request);
    abstract public function handleRepeat($request);

}