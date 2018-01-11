<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:13 AM
 */

namespace App\Attendance\Logics;

abstract class CopySlotUseCase
{

    public static function copy($formRequest)
    {
        return (new static)->handleCopy($formRequest);
    }


    abstract public function handleCopy($formRequest);

}