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
use App\Salary\Models\GenerateSalaryReportLogs;
use App\Salary\Models\PayrollSetting;
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


class ConfirmationController extends Controller
{
    use GlobalUtils;
    use ApiUtils;

    public function getNeedConfirmation()
    {

        $response = array();

        if ($this->checkUserEmployee()) {

            $user = Auth::guard('api')->user(); //user
            $employee = $user->employee; // employee


            $salaryReport = SalaryReport::where('employeeId', $employee->id)
                ->where('confirmationStatusId', 3)//Waiting for Confirmation
                ->whereNotNull('generatePayrollId')
                ->orderBy('id', 'desc')
                ->first();

            if ($salaryReport) {
                $response['isFailed'] = false;
                $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                $response['message'] = 'Success';
                $response['needConfirmation'] = true;
                $response['allowToDispute'] = false; //TODO: logic to allow employee to dipute or not
                $response['salaryReportDetailResponse'] = fractal($salaryReport, new SalaryReportTransformer());

                return response()->json($response, 200);

            } else {
                $response['isFailed'] = false;
                $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                $response['message'] = 'No Report Found';
                $response['needConfirmation'] = false;
                $response['allowToDispute'] = false;

                return response()->json($response, 200);
            }


        } else {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$USER_ERR_CODE['USER_ACCESS_NOT_GRANTED'];
            $response['message'] = 'User\'s access not granted';

            return response()->json($response, 200);
        }
    }

    public function confirmSalary($salaryReportId)
    {
        $response = array();

        if ($this->checkUserEmployee()) {

            if ($salaryReportId == null || $salaryReportId == '') {

                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$ERR_CODE['MISSING_PARAM'];
                $response['message'] = 'Salary Report ID is empty';

                return response()->json($response, 200);
            }

            //is valid

            $user = Auth::guard('api')->user(); //user
            $employee = $user->employee; // employee

            $employeeBranchOfficeId = $this->getResultWithNullChecker1Connection($employee, 'employment', 'branchOfficeId');

            $salaryReport = SalaryReport::find($salaryReportId);

            if ($salaryReport) {
                $confirmType = $this->getConfirmationType($salaryReport->fromDate, $salaryReport->toDate, $employeeBranchOfficeId, $salaryReportId);

                if ($confirmType != null) {

                    $confirmReport = SalaryReport::where('id', $salaryReportId)
                        ->where('employeeId', $employee->id)
                        ->where('confirmationStatusId',3)//waiting confirmation
                        ->update(['confirmationStatusId' => $confirmType,'confirmationDate'=>Carbon::now()->format('d/m/Y')]);

                    if ($confirmReport) { // CONFIRM NOW

                        $response['isFailed'] = false;
                        $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                        $response['message'] = 'Success';

                        //TODO: Trigger event or broadcast to notify that a user has confirmed his/her salary

                        return response()->json($response, 200);

                    } else {
                        $response['isFailed'] = true;
                        $response['code'] = ResponseCodes::$ERR_CODE['ELOQUENT_ERR'];
                        $response['message'] = 'Unable to save data';

                        return response()->json($response, 200);
                    }
                } else {
                    $response['isFailed'] = true;
                    $response['code'] = ResponseCodes::$SALARY_ERR_CODES['CONFIRM_TYPE_UNDEFINED'];
                    $response['message'] = 'Unable to define confirm type';

                    return response()->json($response, 200);
                }
            } else {
                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$SALARY_ERR_CODES['SALARY_REPORT_NOT_FOUND'];
                $response['message'] = 'Unable to find salary report data';

                return response()->json($response, 200);
            }


        } else {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$USER_ERR_CODE['USER_ACCESS_NOT_GRANTED'];
            $response['message'] = 'User\'s access not granted';

            return response()->json($response, 200);
        }
    }

    private function getConfirmationType($fromDate, $toDate, $employeeBranchOfficeId, $salaryReportId)
    {
        $generateSalaryReportLog = GenerateSalaryReportLogs::where('fromDate', $fromDate)->where('toDate', $toDate)->where('branchOfficeId', $employeeBranchOfficeId)->first();

        if ($generateSalaryReportLog) {

            if (in_array($salaryReportId, explode(' ', $generateSalaryReportLog->salaryReportIds))) {

                $reachedStage2 = false;
                $isInStage1 = false;

                /* Payroll setting Max Day to Confirm Stage 1 */
                $maxConfirmationStage1 = PayrollSetting::where('name', 'max-days-confirmation-salary-stage-1')->first()['value'];
                /* Payroll setting Max Day to Confirm Valid Stage */
                $maxConfirmationValidStage = PayrollSetting::where('name', 'max-days-confirmation-salary-valid-stage')->first()['value'];

                /* Check if today is still in stage 1 confirmation*/
                if ($this->totalDays($generateSalaryReportLog->generatedDate, Carbon::now()->format('d/m/Y')) > $maxConfirmationValidStage &&
                    $this->totalDays($generateSalaryReportLog->generatedDate, Carbon::now()->format('d/m/Y')) <= $maxConfirmationStage1
                ) {
                    $isInStage1 = true;
                }

                /* Check if today has reached stage2 confirmation*/
                if ($this->totalDays($generateSalaryReportLog->generatedDate, Carbon::now()->format('d/m/Y')) > $maxConfirmationStage1) {
                    $reachedStage2 = true;
                }


                if ($isInStage1 && !$reachedStage2) {
                    return 4;//stage 1
                }

                if (!$isInStage1 && $reachedStage2) {
                    return 5;//stage 2
                }

                return 1;//valid stage

            } else {
                return null;
            }


        } else {
            return null;
        }

    }

}
