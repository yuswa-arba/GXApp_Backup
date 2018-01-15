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
        if ($request->professionalism == 'professional'){
            return (new static)->handleProfessionalResignation($request);
        } else {
            return (new static)->handleUnprofessionalResignation($request);
        }

    }

    abstract public function handleProfessionalResignation($request);
    abstract public function handleUnprofessionalResignation($request);


}