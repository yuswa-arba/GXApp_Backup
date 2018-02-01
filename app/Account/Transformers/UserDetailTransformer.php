<?php

namespace App\Account\Transformers;

use App\Account\Models\User;
use App\Employee\Models\MasterEmployee;
use App\Traits\GlobalConst;
use App\Traits\GlobalUtils;
use League\Fractal\TransformerAbstract;

class UserDetailTransformer extends TransformerAbstract
{

    use GlobalUtils;

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'accessStatus' => $this->getResultWithNullChecker1Connection($user, 'accessStatus', 'name'),
            'email' => $user->email,
            'allowSuperAdminAccess' => $user->allowSuperAdminAccess,
            'allowAdminAccess' => $user->allowAdminAccess,
            'employeeId' => $this->getResultWithNullChecker1Connection($user, 'employee', 'id'),
            'employeeNo' => $this->getResultWithNullChecker1Connection($user, 'employee', 'employeeNo'),
            'employeeName' => $this->getResultWithNullChecker1Connection($user, 'employee', 'givenName') . ' ' . $this->getResultWithNullChecker1Connection($user, 'employee', 'surname'),
            'nickname' => $this->getResultWithNullChecker1Connection($user, 'employee', 'nickName'),
            'phoneNo' => $this->getResultWithNullChecker1Connection($user, 'employee', 'phoneNo'),
            'bankAccNo'=>$this->getResultWithNullChecker1Connection($user,'employee','bankAccNo'),
            'bankName'=>$this->getResultWithNullChecker2Connection($user,'employee','bank','name'),
            'division'=>$this->getResultWithNullChecker3Connection($user,'employee','employment','division','name'),
            'branchOffice'=>$this->getResultWithNullChecker3Connection($user,'employee','employment','branchOffice','name'),
            'jobPosition'=>$this->getResultWithNullChecker3Connection($user,'employee','employment','jobPosition','name'),
            'photo'=>$this->getResultWithNullChecker1Connection($user,'employee','employeePhoto'),
        ];
    }


}
