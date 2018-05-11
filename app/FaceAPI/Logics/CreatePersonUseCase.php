<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:13 AM
 */

namespace App\FaceAPI\Logics;


use App\Manager\Models\EditTimesheet;

abstract class CreatePersonUseCase
{
    public static function create($request)
    {

        return (new static)->handle($request);

    }

    abstract public function handle($request);

}