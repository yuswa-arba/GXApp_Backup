<?php

namespace App\Account\Transformers;

use App\Account\Models\User;
use App\Employee\Models\MasterEmployee;
use League\Fractal\TransformerAbstract;

class LoginDetailTransfomer extends TransformerAbstract
{


    public function transform(User $user)
    {
        $employee = MasterEmployee::where('id',$user->employeeId)->first();
        return [
            'employeeNo'=>$employee->employeeNo,
            'employeeName'=>$employee->givenName,
            'employeeId' => $user->employeeId,
            'accessStatus'=>$user->accessStatus->name,
            'email'=>$user->email,
            'allowSuperAdminAccess'=>$user->allowSuperAdminAccess,
            'allowAdminAccess'=>$user->allowAdminAccess,
        ];
    }


}
