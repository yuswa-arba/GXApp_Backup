<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Attendance\Logics\Timesheet;

use App\Attendance\Models\AttendanceTimesheet;
use App\Attendance\Transformers\SingleTimesheetListTransformer;
use App\Attendance\Transformers\TimesheetListTransformer;
use App\Employee\Models\Employment;
use App\Http\Controllers\BackendV1\API\Traits\ResponseCodes;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class GetSingleTimesheetListLogic extends GetSingleTimesheetDataUseCase
{
    use GlobalUtils;

    public function handleGetAllTimesheet($request, $employeeId)
    {

        $response = array();

        /* Get timesheet */
        if ($request->sortDate != "") {
            $timesheet = AttendanceTimesheet::where('employeeId', $employeeId)->where('clockInDate', $request->sortDate)->orWhere('clockOutDate', $request->sortDate)->orderBy('id', 'desc')->get();
        } else {
            $timesheet = AttendanceTimesheet::where('employeeId', $employeeId)->orderBy('id', 'desc')->paginate(30);
        }

        if ($timesheet) {

            $response['isFailed'] = false;
            $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
            $response['message'] = 'Success';
            $response['timesheetHistoryResponse'] =  fractal($timesheet, new SingleTimesheetListTransformer());
            return response()->json($response,200);


        } else {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$ATTD_ERR_CODES['TIMESHEET_HISTORY_RECORD_NOT_FOUND'];
            $response['message'] = 'Timesheet history record not found';

            return response()->json($response, 200);
        }

    }

}