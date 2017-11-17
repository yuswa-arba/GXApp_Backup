<?php

namespace App\Employee\Transformers;

use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use League\Fractal\TransformerAbstract;

class EmployeeDetailTransfomer extends TransformerAbstract
{

    protected $defaultIncludes = [
        'employment'
    ];

    public function transform(MasterEmployee $employee)
    {
        return [
            'id' => $employee->id,
            'employeeNo' => $employee->employeeNo,
            'givenName' => $employee->givenName,
            'surname' => $employee->surname,
            'nickName' => $employee->nickName,
            'birthDate' => $employee->birthDate,
            'hometown' => $employee->hometown,
            'gender' => $employee->gender,
            'religion' => !is_null($employee->religion) ? $employee->religion->name : '',
            'city' => $employee->city,
            'address' => $employee->address,
            'email' => $employee->email,
            'altEmail' => $employee->altEmail,
            'phoneNo' => $employee->phoneNo,
            'educationLevel' => !is_null($employee->educationLevel) ? $employee->educationLevel->name : '',
            'maritalStatus' => !is_null($employee->maritalStatus) ? $employee->maritalStatus->name : '',
            'spousesName' => $employee->spousesName,
            'totalChildren' => $employee->totalChildren,
            'idCardNumber' => $employee->idCardNumber,
            'idCardPhoto' => $employee->idCardPhoto,
            'employeePhoto' => $employee->employeePhoto,
            'fatherName' => $employee->fatherName,
            'fatherAddress' => $employee->fatherAddress,
            'fatherCity' => $employee->fatherCity,
            'fatherPhoneNo' => $employee->fatherPhoneNo,
            'fatherMaritalStatus' => !is_null($employee->fatherMaritalStatus) ? $employee->fatherMaritalStatus->name : '',
            'motherName' => $employee->motherName,
            'motherAddress' => $employee->motherAddress,
            'motherCity' => $employee->motherCity,
            'motherPhoneNo' => $employee->motherPhoneNo,
            'motherMaritalStatus' => !is_null($employee->motherMaritalStatus) ? $employee->motherMaritalStatus->name : '',
            'numberOfSiblings' => $employee->numberOfSiblings,
            'siblingName' => $employee->siblingName,
            'siblingAddress' => $employee->siblingAddress,
            'siblingCity' => $employee->siblingCity,
            'siblingPhoneNo' => $employee->siblingPhoneNo,
            'siblingMaritalStatus' => !is_null($employee->siblingMaritalStatus) ? $employee->siblingMaritalStatus->name : '',
            'emergencyContact' => $employee->emergencyContact,
            'emergencyRelationship' => $employee->emergencyRelationship,
            'emergencyAddress' => $employee->emergencyAddress,
            'emergencyCity' => $employee->emergencyCity,
            'emergencyPhoneNo' => $employee->emergencyPhoneNo,
            'emergencyAltPhoneNo' => $employee->emergencyAltPhoneNo,
            'emergencyEmailAddress' => $employee->emergencyEmailAddr,
            'prevCompanyName' => $employee->prevCompanyName,
            'prevCompanyAddress' => $employee->prevCompanyAddress,
            'prevCompanyPhoneNo' => $employee->prevCompanyPhoneNo,
            'prevPosition' => $employee->prevPosition,
            'prevLengthEmployment' => $employee->prevLengthEmployment,
            'bank' => !is_null($employee->bank) ? $employee->bank->name : '',
            'bankAccNo' => $employee->bankAccNo,
            'bankHolderName' => $employee->bankHolderName,
            'bankBranch' => $employee->bankBranch,
            'bankCity' => $employee->bankCity
        ];
    }

    public function includeEmployment(MasterEmployee $employee)
    {
        $employment = Employment::where('employeeId',$employee->id)->get();
        return $this->collection($employment, new EmploymentTransfomer(), 'employment');
    }
}
