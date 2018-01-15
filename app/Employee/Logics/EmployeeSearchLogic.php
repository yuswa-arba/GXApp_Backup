<?php

namespace App\Employee\Logics;

use App\Account\Models\User;
use App\Employee\Events\EmployeeCreated;
use App\Employee\Events\UserGenerated;
use App\Employee\Models\EmployeeDataVerification;
use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Employee\Transformers\EmployeeListTransfomer;
use App\Http\Controllers\BackendV1\Helpdesk\Traits\Configs;
use App\Traits\GlobalUtils;
use GuzzleHttp\Psr7\Request;

class EmployeeSearchLogic extends SearchUseCase
{

    use GlobalUtils;

    public function handleEmployeeSearch($searchText)
    {
        $candidatesEmployee = MasterEmployee::where('employeeNo', 'LIKE', '%' . $searchText . '%')
            ->orWhere('givenName', 'LIKE', '%' . $searchText . '%')
            ->orWhere('surname', 'LIKE', '%' . $searchText . '%')
            ->orWhere('nickName', 'LIKE', '%' . $searchText . '%')->get();

        $response = array();

        if ($candidatesEmployee != null && count($candidatesEmployee)>0) {

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            $response['candidates'] = fractal($candidatesEmployee, new EmployeeListTransfomer());

            return response()->json($response, 200);
        } else {
            $response['isFailed'] = true;
            $response['message'] = 'No employee found';

            return response()->json($response, 200);
        }
    }
}