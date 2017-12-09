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
        $response = array();

        $deleteEmployeeSchedule = EmployeeSlotSchedule::where('employeeId', $request->employeeId)->where('slotId', $request->slotId)->delete();
        if ($deleteEmployeeSchedule) {

            /* Return success response */
            $response['isFailed'] = false;
            $response['message'] = 'Remove slot from employee is successful';
            return response()->json($response, 200);

        } else {



            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'Unable to remove slot from employee';
            return response()->json($response, 500);

        }
    }

    public function handleRandomAssign($request)
    {
        // TODO: Implement handleRandomAssign() method.
    }
}