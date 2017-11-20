<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class EditMasterEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (Auth::user()->allowSuperAdminAccess || Auth::user()->allowAdminAccess);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'phoneNo' => 'required',
            'email' => 'required',
            'employeePhoto' => 'max:2048',
            'idCardPhoto' => 'max:2048',
            'surname' => 'required',
            'givenName' => 'required',
            'nickName' => 'required',
            'gender' => 'required',
            'birthDate' => 'required|date_format:d/m/Y',
            'hometown' => 'required',
            'city' => 'required',
            'educationLevelId' => 'required',
            'religionId' => 'required',
            'maritalStatusId' => 'required',
            'fatherName' => 'required',
            'fatherPhoneNo' => 'required',
            'fatherAddress' => 'required',
            'fatherCity' => 'required',
            'fatherMaritalStatusId' => 'required',
            'motherName' => 'required',
            'motherPhoneNo' => 'required',
            'motherAddress' => 'required',
            'motherCity' => 'required',
            'motherMaritalStatusId' => 'required',
            'idCardNumber' => 'required',
            'address' => 'required',
            'emergencyContact' => 'required',
            'emergencyRelationship' => 'required',
            'emergencyPhoneNo' => 'required',
            'emergencyAddress' => 'required',
            'emergencyCity' => 'required',



        ];


    }
}
