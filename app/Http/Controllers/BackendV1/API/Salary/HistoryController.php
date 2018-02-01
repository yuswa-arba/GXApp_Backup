<?php

namespace App\Http\Controllers\BackendV1\API\Salary;

use App\Account\Traits\TokenUtils;
use App\Attendance\Logics\Attendance\AttendanceLogic;
use App\Attendance\Models\AttendanceSchedule;
use App\Attendance\Models\Shifts;
use App\Employee\Models\MasterEmployee;
use App\Employee\Transformers\EmployeeBriefDetailTransfomer;
use App\Http\Controllers\BackendV1\API\Traits\ApiUtils;
use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use App\Http\Controllers\BackendV1\API\Traits\ResponseCodes;
use App\Http\Controllers\BackendV1\Helpdesk\Traits\Configs;
use App\Http\Controllers\Controller;
use App\Salary\Models\SalaryCalculation;
use App\Salary\Models\SalaryReport;
use App\Salary\Transformers\BriefEmployeeSalaryReportTransformer;
use App\Salary\Transformers\SalaryCalculationTransformer;
use App\Salary\Transformers\SalaryReportTransformer;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class HistoryController extends Controller
{
    use GlobalUtils;
    use ApiUtils;

    public function getList()
    {
        if ($this->checkUserEmployee()) {

            $user = Auth::guard('api')->user(); //user
            $employee = $user->employee; // employee

            $salaryReportHistory = SalaryReport::where('employeeId', $employee->id)->whereNotNull('generatePayrollId')->orderBy('id', 'desc')->paginate(30);

            if($salaryReportHistory){
                $response['isFailed'] = false;
                $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                $response['message'] = 'Success';
                $response['salaryHistoryResponse'] = fractal($salaryReportHistory, new BriefEmployeeSalaryReportTransformer())->toArray();

                return response()->json($response,200);

            } else {
                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$SALARY_ERR_CODES['SALARY_REPORT_NOT_FOUND'];
                $response['message'] = 'Salary report not found';

                return response()->json($response, 200);
            }


        } else {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$USER_ERR_CODE['USER_ACCESS_NOT_GRANTED'];
            $response['message'] = 'User\'s access not granted';

            return response()->json($response, 200);
        }
    }

    public function getDetail($salaryReportId)
    {
        $response = array();

        if($salaryReportId==null||$salaryReportId==''){

            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$ERR_CODE['MISSING_PARAM'];
            $response['message'] = 'Salary Report ID is empty';

            return response()->json($response,200);
        }

        $salaryReport = SalaryReport::find($salaryReportId);
        if($salaryReport){

            $salaryCalculation = SalaryCalculation::where('salaryReportId',$salaryReport->id)->where('isDeleted',0)->where('isProcessed',1)->get();

            $response['isFailed'] = false;
            $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
            $response['message'] = 'Success';
            $response['salaryReportDetailResponse'] = fractal($salaryReport,new SalaryReportTransformer());
            $response['salaryReportCalculationResponse'] = fractal($salaryCalculation,new SalaryCalculationTransformer());

            return response()->json($response,200);


        } else {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$SALARY_ERR_CODES['SALARY_REPORT_NOT_FOUND'];
            $response['message'] = 'Salary report not found';

            return response()->json($response, 200);
        }


    }
}
