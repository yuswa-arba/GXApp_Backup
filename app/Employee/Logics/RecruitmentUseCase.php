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
use App\Http\Requests\Employee\MedicalRecordsRequest;
use Illuminate\Http\Request;

abstract class RecruitmentUseCase
{

    public static function createEmployee(MasterEmployeeRequest $request)
    {
        return (new static)->handleNewEmployeeForm($request);
    }

    abstract public function handleNewEmployeeForm($string);


    public static function submitEmployment(EmploymentRequest $request)
    {
        return (new static)->handleEmployment($request);
    }

    abstract public function handleEmployment($request);

    public static function submitMedicalRecords(MedicalRecordsRequest $request)
    {
        return (new static)->handleMedicalRecords($request);
    }

    abstract public function handleMedicalRecords($request);

}