<?php

namespace App\Http\Controllers\BackendV1\API\Attendance;

use App\Account\Models\User;
use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\EmployeeLeaveSchedule;
use App\Attendance\Models\Kiosks;
use App\Attendance\Models\PublicHolidaySchedule;
use App\Attendance\Models\Shifts;
use App\Attendance\Models\SlotShiftSchedule;
use App\Attendance\Transformers\DayOffSingleCalendarAPITransformer;
use App\Attendance\Transformers\DayOffSingleCalendarTransformer;
use App\Attendance\Transformers\EmployeeLeaveScheduleSingleCalendarAPITransformer;
use App\Attendance\Transformers\KioskTransformer;
use App\Attendance\Transformers\PublicHolidayScheduleSingleCalendarAPITransformer;
use App\Attendance\Transformers\ShiftListTransformer;
use App\Attendance\Transformers\ShiftScheduleSingleCalendarAPITransformer;
use App\Employee\Models\FacePerson;
use App\Employee\Transformers\EmployeeLastActivityTransfomer;
use App\Http\Controllers\BackendV1\API\Traits\ApiUtils;
use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use App\Http\Controllers\BackendV1\API\Traits\ResponseCodes;
use App\Http\Controllers\Controller;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client;


class CalendarController extends Controller
{

    use GlobalUtils;
    use ApiUtils;

    public function detail()
    {

        $response = array();

        if ($this->checkUserEmployee()) {

            $user = Auth::guard('api')->user(); //user
            $employee = $user->employee; // employee

            if ($employee) {

                $slotId = 1; //default set to General Slot

                if ($this->getResultWithNullChecker1Connection($employee, 'slotSchedule', 'id')) {
                    $slotId = $this->getResultWithNullChecker1Connection($employee, 'slotSchedule', 'slotId');
                }

                $dayOffSchedule = DayOffSchedule::where('slotId', $slotId)->where(function ($query) {
                    $query->where('date','like','%'.$this->currentYear())->orWhere('date','like','%'.$this->lastYear()); //get this year and last year
//                    $query->where('date', 'like', '%' . $this->currentYear()); //get only current year

                })->get();

                $shiftSchedule = SlotShiftSchedule::where('slotId', $slotId)->where(function ($query) {
                    $query->where('date','like','%'.$this->currentYear())->orWhere('date','like','%'.$this->lastYear()); //get this year and last year
//                    $query->where('date', 'like', '%' . $this->currentYear()); //get only current year
                })->get();

                $publicHolidaySchedule = PublicHolidaySchedule::where('fromSlotId', $slotId)->where(function ($query) {
                    $query->where('applyDate','like','%'.$this->currentYear())->orWhere('applyDate','like','%'.$this->lastYear()); //get this year and last year
//                    $query->where('date', 'like', '%' . $this->currentYear()); //get only current year
                })->get();

                $paidLeaveSchedule = EmployeeLeaveSchedule::where('employeeId',$employee->id)->where(function ($query){
                    $query->where('year', $this->currentYear())->orWhere('year',$this->lastYear());
                })->where('leaveApprovalId',ConfigCodes::$LEAVE_APPROVAL['APPROVED'])->get();

                $response['isFailed'] = false;
                $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                $response['message'] = 'Success';
                $response['dayOffResponse'] = fractal($dayOffSchedule, new DayOffSingleCalendarAPITransformer());
                $response['shiftScheduleResponse'] = fractal($shiftSchedule, new ShiftScheduleSingleCalendarAPITransformer());
                $response['publicHolidayResponse'] = fractal($publicHolidaySchedule, new PublicHolidayScheduleSingleCalendarAPITransformer());
                $response['paidLeaveResponse'] = fractal($paidLeaveSchedule,new EmployeeLeaveScheduleSingleCalendarAPITransformer());

                $existingShift = Shifts::whereIn('id',$this->getShiftSummary($shiftSchedule->pluck('shiftId')))->get();
                $response['shiftSummaryResponse'] = fractal($existingShift, new ShiftListTransformer());

                return response()->json($response, 200);


            } else {
                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$ATTD_ERR_CODES['EMPLOYEE_NOT_FOUND'];
                $response['message'] = 'Employee data not found';
                return response()->json($response, 200);
            }


        } else {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$USER_ERR_CODE['USER_ACCESS_NOT_GRANTED'];
            $response['message'] = 'User\'s access not granted';

            return response()->json($response, 200);
        }
    }

    private function getShiftSummary($pluck)
    {
        $uniqueShiftId = array();

        if(count($pluck)>0){

            for($i=0;$i<count($pluck);$i++){

                if(!in_array($pluck[$i],$uniqueShiftId)){
                    array_push($uniqueShiftId,$pluck[$i]);
                }

            }

        }
        return $uniqueShiftId;
    }

}
