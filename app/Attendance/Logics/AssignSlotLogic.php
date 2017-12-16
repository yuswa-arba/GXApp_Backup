<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Attendance\Logics;

use App\Attendance\Models\EmployeeSlotSchedule;
use App\Attendance\Models\Slots;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AssignSlotLogic extends AssignUseCase
{

    public function handleAssign($request)
    {
        $request->request->add(['setBy' => !is_null(Auth::user()->employee) ? Auth::user()->employee->givenName : '']);
        $request->request->add(['setAt' => Carbon::now()]);
        $requestData = $request->all();


        if($this->slotAvailableToBeAssigned($request->slotId)){
            $employeeSlotSchedule = EmployeeSlotSchedule::create($requestData);

            $response = array();

            if ($employeeSlotSchedule) {
                /* Return success response */
                $response['isFailed'] = false;
                $response['message'] = 'Assign employee to slot is successful';

                return response()->json($response, 200);

            } else {
                /* Return error response */
                $response['isFailed'] = true;
                $response['message'] = 'Unable to assign employee to slot';
                return response()->json($response, 200);
            }
        }else {
            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'This slot is currently assigned to other employee';
            return response()->json($response, 200);
        }

    }

    public function handleRemove($request)
    {
        $response = array();

        $deleteEmployeeSchedule = EmployeeSlotSchedule::where('employeeId', $request->employeeId)->delete();
        if ($deleteEmployeeSchedule) {

            /* Return success response */
            $response['isFailed'] = false;
            $response['message'] = 'Remove employee from slot is successful.';
            return response()->json($response, 200);

        } else {



            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'Unable to remove employee from slot';
            return response()->json($response, 200);

        }
    }

    public function handleRandomAssign($request)
    {
        // TODO: Implement handleRandomAssign() method.
    }

    private function slotAvailableToBeAssigned($slotId)
    {
        $slot = Slots::find($slotId);
        if (!$slot->allowMultipleAssign && count($slot->slotSchedule) > 0) {
            return false;
        } else {
            return true;
        }
    }
}