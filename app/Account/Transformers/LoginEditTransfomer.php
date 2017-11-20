<?php

namespace App\Account\Transformers;

use App\Account\Models\AccessStatus;
use App\Account\Models\User;
use App\Components\Models\BranchOffice;
use App\Components\Models\Division;
use App\Components\Models\JobPosition;
use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Employee\Models\RecruitmentStatus;
use League\Fractal\TransformerAbstract;

class LoginEditTransfomer extends TransformerAbstract
{

    public function transform(User $user)
    {
        $employee = MasterEmployee::where('id', $user->employeeId)->first();

        return [
            'employeeId' => $user->employeeId,
            'employeeNo' => $employee->employeeNo,
            'employeeName' => $employee->givenName,
            'email'=> $user->email,
            'accessStatusId'=>$user->accessStatusId,
            'allowSuperAdminAccess'=>$user->allowSuperAdminAccess,
            'allowAdminAccess'=>$user->allowAdminAccess,
            'formComponents' => $this->includeFormComponents()

        ];
    }

    public function includeFormComponents()
    {
        $accessStatuses = AccessStatus::select('id','name')->get();

        return [
            'accessStatuses' => $accessStatuses,
        ];
    }


}
