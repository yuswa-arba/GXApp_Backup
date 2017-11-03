<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'givenName' => 'required',
            'surname' => 'required',
            'nickName' => 'required',
            'birthDate' => 'required|date_format:dd/mm/yyyy',
            'gender' => 'required',
            'religionId' => 'required',
            'city' => 'required',
            'address' => 'required',
            'email' => 'required',
            'phoneNo' => 'required',
            'educationLevelId' => 'required',
            'maritalStautsId'=>'required',
            'idCardNumber' => 'required',
            'idCardPhoto' => 'required|mimes:jpeg,bmp,png|max:5000',
            'employeePhoto'=>'mimes:jpeg,bmp,png|max:5000',
            'motherName' => 'required',
            'motherPhoneNo' => 'required',
            'motherAddress' => 'required',
            'motherMaritalStatusId' => 'required',
            'fatherName' => 'required',
            'fatherPhoneNo' => 'required',
            'fatherAddress' => 'required',
            'fatherMaritalStatusId' => 'required',
            'emergencyContact' => 'required',
            'emergencyRelationship' => 'required',
            'emergencyPhoneNo' => 'required',
            'emergencyAddress' => 'required',
            'emergencyEmailAddress' => 'required',
        ];
    }
}
