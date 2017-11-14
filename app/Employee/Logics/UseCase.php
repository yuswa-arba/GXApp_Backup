<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 13/11/17
 * Time: 8:55 AM
 */

namespace App\Employee\Logics;




use App\Http\Requests\Employee\EmploymentRequest;
use App\Http\Requests\Employee\MasterEmployeeRequest;
use Illuminate\Http\Request;

abstract class UseCase
{


    public static function createEmployeeLogic(MasterEmployeeRequest $request)
    {
        return (new static)->handleNewEmployeeForm($request);
    }

    abstract public function handleNewEmployeeForm($string);



    public static function submitEmploymentLogic(EmploymentRequest $request)
    {
        return (new static)->handleEmployment($request);
    }

    abstract public function handleEmployment($request);


}