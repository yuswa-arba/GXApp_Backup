<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EmploymentRequest extends FormRequest
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
            'employeeId'=>'required',
            'jobPositionId'=>'required',
            'divisionId'=>'required',
            'activityStatusId'=>'required',
            'branchOfficeId'=>'required',
            'recruitmentStatusId'=>'required',
            'dateOfEntry'=>'required|date_format:d/m/Y',
            'dateOfStart'=>'required|date_format:d/m/Y',
        ];
    }
}
