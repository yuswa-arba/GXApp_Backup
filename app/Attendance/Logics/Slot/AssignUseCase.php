<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:13 AM
 */

namespace App\Attendance\Logics\Slot;


use Illuminate\Http\Request;

abstract class AssignUseCase
{
    public static function assign(Request $request)
    {
        return (new static)->handleAssign($request);
    }

    public static function remove(Request $request)
    {
        return (new static)->handleRemove($request);
    }

    public static function assignRandom(Request $request)
    {
        return (new static)->handleRandomAssign($request);
    }

    abstract public function handleAssign($request);

    abstract public function handleRemove($request);

    abstract public function handleRandomAssign($request);

}