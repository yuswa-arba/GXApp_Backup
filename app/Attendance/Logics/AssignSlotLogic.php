<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Attendance\Logics;

use App\Attendance\Models\EmployeeSlotSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AssignSlotLogic extends AssignUseCase
{

    public function handleAssign($request)
    {
        $request->request->add(['setBy' => !is_null(Auth::user()->employee) ? Auth::user()->employee->givenName : '']);
        $request->request->add(['setAt' => Carbon::now()]);
        $requestData = $request->all();

        $employeeSlotSchedule = EmployeeSlotSchedule::create($requestData);

        $response = array();

        if ($employeeSlotSchedule) {
            /* Return success response */
            $response['isFailed'] = false;
            $response['message'] = 'Assign slot to employee is successful';
            $response['employeeSlotData'] = $employeeSlotSchedule;
            $response['employeeSlotData']['slot'] =$employeeSlotSchedule->slot;

            return response()->json($response, 200);

        } else {
            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'Unable to assign slot to employee';
            return response()->json($response, 500);
        }

    }

    public function handleRemove($request)
    {
        // TODO: Implement handleRemove() method.
    }

    public function handleRandomAssign($request)
    {
        // TODO: Implement handleRandomAssign() method.
    }
}