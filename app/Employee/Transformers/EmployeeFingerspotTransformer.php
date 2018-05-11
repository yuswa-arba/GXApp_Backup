<?php

namespace App\Employee\Transformers;

use App\Employee\Models\EmployeeSiblings;
use App\Employee\Models\Employment;
use App\Employee\Models\FingerspotUser;
use App\Employee\Models\MasterEmployee;
use League\Fractal\TransformerAbstract;

class EmployeeFingerspotTransformer extends TransformerAbstract
{

    public function transform(FingerspotUser $user)
    {
        return [
            'id' => $user->id,
            'employeeId' => $user->employeeId,
            'fingerspotUserId' => $user->fingerspotUserId
        ];
    }

}
