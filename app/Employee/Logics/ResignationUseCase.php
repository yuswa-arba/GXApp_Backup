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

abstract class ResignationUseCase
{


    public static function resign(Request $request)
    {
        return (new static)->handleResignation($request);
    }

    abstract public function handleResignation($string);


}