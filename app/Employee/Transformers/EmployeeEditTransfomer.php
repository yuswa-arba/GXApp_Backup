<?php

namespace App\Employee\Transformers;

use App\Components\Models\Bank;
use App\Components\Models\EducationLevel;
use App\Components\Models\MaritalStatus;
use App\Components\Models\Religion;
use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use League\Fractal\TransformerAbstract;

class EmployeeEditTransfomer extends TransformerAbstract
{


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
            'religionId' => $employee->religionId,
            'city' => $employee->city,
            'address' => $employee->address,
            'email' => $employee->email,
            'altEmail' => $employee->altEmail,
            'phoneNo' => $employee->phoneNo,
            'educationLevelId' => $employee->educationLevelId,
            'maritalStatusId' => $employee->maritalStatusId,
            'spousesName' => $employee->spousesName,
            'totalChildren' => $employee->totalChildren,
            'idCardNumber' => $employee->idCardNumber,
            'idCardPhoto' => $employee->idCardPhoto,
            'employeePhoto' => $employee->employeePhoto,
            'fatherName' => $employee->fatherName,
            'fatherAddress' => $employee->fatherAddress,
            'fatherCity' => $employee->fatherCity,
            'fatherPhoneNo' => $employee->fatherPhoneNo,
            'fatherMaritalStatusId' => $employee->fatherMaritalStatusId,
            'fatherIsDeceased'=>$employee->fatherIsDeceased,
            'motherName' => $employee->motherName,
            'motherAddress' => $employee->motherAddress,
            'motherCity' => $employee->motherCity,
            'motherPhoneNo' => $employee->motherPhoneNo,
            'motherMaritalStatusId' => $employee->motherMaritalStatusId,
            'motherIsDeceased'=>$employee->motherIsDeceased,
            'numberOfSiblings' => $employee->numberOfSiblings,
            'emergencyContact' => $employee->emergencyContact,
            'emergencyRelationship' => $employee->emergencyRelationship,
            'emergencyAddress' => $employee->emergencyAddress,
            'emergencyCity' => $employee->emergencyCity,
            'emergencyPhoneNo' => $employee->emergencyPhoneNo,
            'emergencyAltPhoneNo' => $employee->emergencyAltPhoneNo,
            'emergencyEmailAddress' => $employee->emergencyEmailAddress,
            'prevCompanyName' => $employee->prevCompanyName,
            'prevCompanyAddress' => $employee->prevCompanyAddress,
            'prevCompanyPhoneNo' => $employee->prevCompanyPhoneNo,
            'prevPosition' => $employee->prevPosition,
            'prevLengthEmployment' => $employee->prevLengthEmployment,
            'bankId' => $employee->bankId,
            'bankAccNo' => $employee->bankAccNo,
            'bankHolderName' => $employee->bankHolderName,
            'bankBranch' => $employee->bankBranch,
            'bankCity' => $employee->bankCity,
            'formComponents' => $this->includeFormComponents()
        ];
    }

    public function includeFormComponents()
    {
        $maritalStatuses = MaritalStatus::select('id', 'name')->get();
        $banks = Bank::select('id', 'name')->get();
        $religions = Religion::select('id', 'name')->get();
        $educationLevels = EducationLevel::select('id', 'name')->get();

        return [
            'maritalStatuses' => $maritalStatuses,
            'banks' => $banks,
            'religions' => $religions,
            'educationLevels' => $educationLevels
        ];
    }

}
