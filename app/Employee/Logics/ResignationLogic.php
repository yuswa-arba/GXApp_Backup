<?php

namespace App\Employee\Logics;

use App\Account\Models\User;
use App\Employee\Events\EmployeeCreated;
use App\Employee\Events\UserGenerated;
use App\Employee\Models\EmployeeDataVerification;
use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Http\Controllers\BackendV1\Helpdesk\Traits\Configs;
use App\Traits\GlobalUtils;
use GuzzleHttp\Psr7\Request;

class Resignation extends ResignationUseCase
{

    use GlobalUtils;


    public function handleResignation($string)
    {
        // TODO: Implement handleResignation() method.
    }
}