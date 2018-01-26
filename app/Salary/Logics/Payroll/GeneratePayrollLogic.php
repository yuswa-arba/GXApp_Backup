<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Salary\Logics\Payroll;

use App\Http\Controllers\BackendV1\Helpdesk\Traits\Configs;
use App\Salary\Models\GeneratePayroll;
use App\Salary\Models\GenerateSalaryReportLogs;
use App\Salary\Models\PayrollSetting;
use App\Salary\Models\SalaryReport;
use App\Salary\Traits\SalaryCheckerUtil;
use App\Salary\Transformers\BriefEmployeeDetailSalaryReportTransformer;
use App\Salary\Transformers\PayrollGeneratedSalaryHistoryTransformer;
use App\Salary\Transformers\SalaryReportTransformer;
use App\Traits\GlobalUtils;
use Carbon\Carbon;


class GeneratePayrollLogic extends GenerateUseCase
{

    use SalaryCheckerUtil;
    use GlobalUtils;

    public function handle($request)
    {


    }

    //1. Get salary report log data
    //2. Get salaryReportIds from salary report log model
    //3. Run check through salary report logs to make sure confirmationStatusId is correct
    //4. Get Salary Report Log data
    //5. Generate preview of whats going to be generated :
    // - valid stage salary report lists (all salary report logs model that confirmation status ID == 1)
    // - stage 1 salary report list (all salary report logs model that confirmation status ID == 4)
    // - stage 2 salary report list (all salary report logs model that confirmation status ID == 5)
    public function handleAttempt($request)
    {
        /* Response array */
        $response = array();

        /* Generate Salary Repot Log*/
        $generateSalaryReport = GenerateSalaryReportLogs::find($request->generateSalaryReportLogId);

        /* Salary Reports Data */
        $salaryReports = SalaryReport::whereIn('id', explode(' ', $generateSalaryReport->salaryReportIds))->get();

        if ($generateSalaryReport) {

            /* Check */
           $this->checkStage2Confirm($generateSalaryReport,$salaryReports);

            /* Insert to details*/
            $details = array();
            $details['confirmed'] = [];
            $details['unconfirmed'] =[];
            $details['stage1Confirmed'] = [];
            $details['stage2Confirmed'] = [];
            $details['waiting']=[];

            foreach ($salaryReports as $salaryReport){
                switch ($salaryReport->confirmationStatusId){
                    case 1 :
                        array_push($details['confirmed'],fractal($salaryReport,new BriefEmployeeDetailSalaryReportTransformer())->toArray()['data']);
                        break;
                    case 2 :
                        array_push($details['unconfirmed'],fractal($salaryReport,new BriefEmployeeDetailSalaryReportTransformer())->toArray()['data']);
                        break;
                    case 3 :
                        array_push($details['waiting'],fractal($salaryReport,new BriefEmployeeDetailSalaryReportTransformer())->toArray()['data']);
                        break;
                    case 4 :
                        array_push($details['stage1Confirmed'],fractal($salaryReport,new BriefEmployeeDetailSalaryReportTransformer())->toArray()['data']);
                        break;
                    case 5 :
                        array_push($details['stage2Confirmed'],fractal($salaryReport,new BriefEmployeeDetailSalaryReportTransformer())->toArray()['data']);
                        break;
                    default:break;
                }
            }

            /* Check availability*/
            $availability = array();
            $availability['normal'] = false;
            $availability['normal-existed']['isExist'] = false;
            $availability['stage1'] = false;
            $availability['stage1-existed']['isExist'] = false;

            /* Payroll setting Max Day to Confirm Stage 1 */
            $maxConfirmationStage1 = PayrollSetting::where('name', 'max-days-confirmation-salary-stage-1')->first()['value'];
            $maxConfirmationValidStage = PayrollSetting::where('name', 'max-days-confirmation-salary-valid-stage')->first()['value'];

            /* Check if today is in stage 1 confirmation*/
            if ($this->totalDays($generateSalaryReport->generatedDate, Carbon::now()->format('d/m/Y')) > $maxConfirmationValidStage) {

                $availability['normal'] = true;

                /* Check if already exist */
                $payroll = GeneratePayroll::where('generatedType',Configs::$GENERATED_PAYROLL_TYPE['CONFIRMED'])->where('salaryReportLogId',$request->generateSalaryReportLogId)->first();
                if($payroll>0){
                    $availability['normal-existed']['isExist'] = true;
                    $availability['normal-existed']['payrollId'] = $payroll->id;
                    $availability['normal-existed']['generatedDate'] = $payroll->generatedDate;
                    $availability['normal-existed']['generatedby'] = $payroll->generatedBy;
                }
            }

            /* Check if today is in stage 1 confirmation*/
            if ($this->totalDays($generateSalaryReport->generatedDate, Carbon::now()->format('d/m/Y')) > $maxConfirmationStage1) {

                $availability['stage1'] = true;

                /* Check if already exist */
                $payroll = GeneratePayroll::where('generatedType',Configs::$GENERATED_PAYROLL_TYPE['STAGE_1_CONFIRMED'])->where('salaryReportLogId',$request->generateSalaryReportLogId)->first();
                if($payroll>0){
                    $availability['stage1-existed']['isExist'] = true;
                    $availability['stage1-existed']['payrollId'] = $payroll->id;
                    $availability['stage1-existed']['generatedDate'] = $payroll->generatedDate;
                    $availability['stage1-existed']['generatedby'] = $payroll->generatedBy;
                }
            }



            /* Insert to response array */
            $response['isFailed'] = false;
            $response['message'] = 'Success';
            $response['reports']['summary'] = fractal($generateSalaryReport,new PayrollGeneratedSalaryHistoryTransformer())->toArray()['data'];
            $response['reports']['details'] = $details;
            $response['reports']['availability'] = $availability;

            return response()->json($response,200);

        } else { // Error response

            $response['isFailed'] = true;
            $response['message'] = 'Unable to find generate salary report';
            return response()->json($response, 200);

        }

    }


}