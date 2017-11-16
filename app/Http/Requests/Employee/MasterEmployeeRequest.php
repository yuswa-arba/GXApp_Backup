<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MasterEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (Auth::user()->allowSuperAdminAccess||Auth::user()->allowAdminAccess);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'surname' => 'required',
            'givenName' => 'required',
            'nickName' => 'required',
            'gender' => 'required',
            'birthDate' => 'required|date_format:d/m/Y',
            'city' => 'required',
            'educationLevelId' => 'required',
            'religionId' => 'required',
            'maritalStatusId'=>'required',
            'fatherName' => 'required',
            'fatherPhoneNo' => 'required',
            'fatherAddress' => 'required',
            'fatherMaritalStatusId' => 'required',
            'motherName' => 'required',
            'motherPhoneNo' => 'required',
            'motherAddress' => 'required',
            'motherMaritalStatusId' => 'required',
            'idCardNumber' => 'required',
            'idCardPhoto' => 'max:2048',
            'address' => 'required',
            'phoneNo' => 'required|unique:MasterEmployee',
            'email' => 'required|unique:MasterEmployee',
            'employeePhoto'=>'max:2048',
            'emergencyContact' => 'required',
            'emergencyRelationship' => 'required',
            'emergencyPhoneNo' => 'required',
            'emergencyAddress' => 'required',
            'emergencyEmailAddress' => 'required',
        ];
    }
}
