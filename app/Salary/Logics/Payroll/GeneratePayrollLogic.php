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
use App\Salary\Models\SalaryCalculation;
use App\Salary\Models\SalaryReport;
use App\Salary\Traits\SalaryCheckerUtil;
use App\Salary\Transformers\BriefEmployeeDetailSalaryReportTransformer;
use App\Salary\Transformers\PayrollGeneratedSalaryHistoryTransformer;
use App\Salary\Transformers\SalaryReportTransformer;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class GeneratePayrollLogic extends GenerateUseCase
{

    use SalaryCheckerUtil;
    use GlobalUtils;

    public function handle($request)
    {
        /* Response array */
        $response = array();

        /* Generate Salary Repot Log*/
        $generateSalaryReport = GenerateSalaryReportLogs::find($request->generateSalaryReportLogId);
        if ($generateSalaryReport) {

            /* Salary Reports Data */
            $salaryReports = null;

            if ($request->generateType == Configs::$GENERATED_PAYROLL_TYPE['CONFIRMED']) {
                $salaryReports = SalaryReport::whereIn('id', explode(' ', $generateSalaryReport->salaryReportIds))->where('confirmationStatusId', 1)->get(); // status Confirmed
            } elseif ($request->generateType == Configs::$GENERATED_PAYROLL_TYPE['STAGE_1_CONFIRMED']) {
                $salaryReports = SalaryReport::whereIn('id', explode(' ', $generateSalaryReport->salaryReportIds))->where('confirmationStatusId', 4)->get(); // status Stage 1 Confirmed
            }


            if ($salaryReports) {

                /* Payroll Reports */
                $payrollReports = array();

                // CSV Title (1st Row)
                $payrollReports[0]['accNo'] = 'Acc. No.';
                $payrollReports[0]['transAmount'] = 'Trans. Amount';
                $payrollReports[0]['empNumber'] = 'emp.Number';
                $payrollReports[0]['empName'] = 'emp.Name';
                $payrollReports[0]['dept'] = 'Dept';
                $payrollReports[0]['transDate'] = 'Trans. Date';

                $i = 1;
                foreach ($salaryReports as $salaryReport) {

                    /* Check if employee exist */
                    if ($salaryReport->employee) {

                        $employee = $salaryReport->employee;

                        /* Make sure only get employee that is not resigned*/
                        if (!$employee->hasResigned) {

                            /* Make sure employee bank acc number exist */
                            if ($employee->bankAccNo) {

                                $payrollReports[$i]['accNo'] = $employee->bankAccNo;
                                $payrollReports[$i]['transAmount'] = $salaryReport->salaryReceived.'.00'; // format : " 1850000.00"
                                $payrollReports[$i]['empNumber'] = $employee->employeeNo;
                                $payrollReports[$i]['empName'] = $employee->givenName . ' ' . $employee->surname;
                                $payrollReports[$i]['dept'] = $this->getResultWithNullChecker2Connection($employee, 'employment', 'division', 'name');
                                $payrollReports[$i]['transDate'] = Carbon::createFromFormat('d/m/Y', $request->transferDate)->format('d-M-y');

                                $i++; //increment
                            }
                        }
                    }
                }

                /* Make sure payroll reports is not empty*/
                if ($payrollReports) {


                    $csvFileName = 'PR' . Carbon::now()->format('dmY') . 'ID' . $request->generateSalaryReportLogId . '.csv';
                    $csvFilePath = Configs::$DOWNLOAD_PATH['PAYROLL_REPORT'] . $csvFileName;


                    /* Create CSV File*/
                    $fp = fopen(base_path($csvFilePath), 'w');
                    foreach ($payrollReports as $payrollReport) {
                        fputcsv($fp, $payrollReport);
                    }
                    fclose($fp);

                    /* Save to DB*/
                    $create = GeneratePayroll::create([
                        'fromDate'=>$generateSalaryReport->fromDate,
                        'toDate'=>$generateSalaryReport->toDate,
                        'branchOfficeId'=>$generateSalaryReport->toDate,
                        'file'=>$csvFileName, //save file name
                        'generatedDate'=>Carbon::now()->format('d/m/Y'),
                        'generatedBy'=>$this->getResultWithNullChecker1Connection(Auth::user(),'employee','name'),
                        'generatedType'=>$request->generateType,
                        'totalEmployee'=>count($payrollReports)-1, //minus first row
                        'notes'=>$request->notes,
                        'generateSalaryReportLogId'=>$request->generateSalaryReportLogId
                    ]);


                    if($create){

                        //Update Generate Salary Report Log
                        $generateSalaryReport->isGeneratedForPayroll = 1;
                        $generateSalaryReport->lastDateGeneratedForPayroll = Carbon::now()->format('d/m/Y');
                        $generateSalaryReport->lastGeneratePayrollId = $create->id;
                        $generateSalaryReport->save();


                        // Update Salary Report
                        foreach ($salaryReports as $salaryReport){

                            $salaryReport->isSubmittedForPayroll = 1;
                            $salaryReport->generatePayrollId = $create->id;
                            $salaryReport->save();

                            // Update Salary Calculation
                            SalaryCalculation::where('salaryReportId',$salaryReport->id)->update(['isProcessed'=>1,'processedDate'=>Carbon::now()->format('d/m/Y')]);

                        }

                        // Success Response
                        $response['isFailed'] = false;
                        $response['message'] = 'Generate payroll is successful';
                        $response['payrollReportFile'] = $create->file;

                        return response()->json($response, 200);

                    } else {

                        // Error Response
                        $response['isFailed'] = true;
                        $response['message'] = 'Unable to save payroll data to database';

                        return response()->json($response, 200);
                    }

                } else {

                    // Error Response
                    $response['isFailed'] = true;
                    $response['message'] = 'Payroll report is empty';

                    return response()->json($response, 200);
                }

            } else { // Error response

                $response['isFailed'] = true;
                $response['message'] = 'Unable to find salary reports data';
                return response()->json($response, 200);

            }
        } else { // Error response

            $response['isFailed'] = true;
            $response['message'] = 'Unable to find generate salary report';
            return response()->json($response, 200);

        }
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
            $this->checkStage2Confirm($generateSalaryReport, $salaryReports);

            /* Insert to details*/
            $details = array();
            $details['confirmed'] = [];
            $details['unconfirmed'] = [];
            $details['stage1Confirmed'] = [];
            $details['stage2Confirmed'] = [];
            $details['waiting'] = [];

            foreach ($salaryReports as $salaryReport) {
                switch ($salaryReport->confirmationStatusId) {
                    case 1 :
                        array_push($details['confirmed'], fractal($salaryReport, new BriefEmployeeDetailSalaryReportTransformer())->toArray()['data']);
                        break;
                    case 2 :
                        array_push($details['unconfirmed'], fractal($salaryReport, new BriefEmployeeDetailSalaryReportTransformer())->toArray()['data']);
                        break;
                    case 3 :
                        array_push($details['waiting'], fractal($salaryReport, new BriefEmployeeDetailSalaryReportTransformer())->toArray()['data']);
                        break;
                    case 4 :
                        array_push($details['stage1Confirmed'], fractal($salaryReport, new BriefEmployeeDetailSalaryReportTransformer())->toArray()['data']);
                        break;
                    case 5 :
                        array_push($details['stage2Confirmed'], fractal($salaryReport, new BriefEmployeeDetailSalaryReportTransformer())->toArray()['data']);
                        break;
                    default:
                        break;
                }
            }

            /* Check availability*/
            $availability = array();
            $availability['normal'] = false;
            $availability['normalExisted']['isExist'] = false;
            $availability['stage1'] = false;
            $availability['stage1Existed']['isExist'] = false;

            /* Payroll setting Max Day to Confirm Stage 1 */
            $maxConfirmationStage1 = PayrollSetting::where('name', 'max-days-confirmation-salary-stage-1')->first()['value'];
            $maxConfirmationValidStage = PayrollSetting::where('name', 'max-days-confirmation-salary-valid-stage')->first()['value'];

            /* Check if today is in stage 1 confirmation*/
            if ($this->totalDays($generateSalaryReport->generatedDate, Carbon::now()->format('d/m/Y')) > $maxConfirmationValidStage) {

                $availability['normal'] = true;

                /* Check if already exist */
                $payroll = GeneratePayroll::where('generatedType', Configs::$GENERATED_PAYROLL_TYPE['CONFIRMED'])->where('generateSalaryReportLogId', $request->generateSalaryReportLogId)->first();
                if ($payroll > 0) {
                    $availability['normalExisted']['isExist'] = true;
                    $availability['normalExisted']['payrollId'] = $payroll->id;
                    $availability['normalExisted']['generatedDate'] = $payroll->generatedDate;
                    $availability['normalExisted']['generatedby'] = $payroll->generatedBy;
                }
            }

            /* Check if today is in stage 1 confirmation*/
            if ($this->totalDays($generateSalaryReport->generatedDate, Carbon::now()->format('d/m/Y')) > $maxConfirmationStage1) {

                $availability['stage1'] = true;

                /* Check if already exist */
                $payroll = GeneratePayroll::where('generatedType', Configs::$GENERATED_PAYROLL_TYPE['STAGE_1_CONFIRMED'])->where('generateSalaryReportLogId', $request->generateSalaryReportLogId)->first();
                if ($payroll > 0) {
                    $availability['stage1Existed']['isExist'] = true;
                    $availability['stage1Existed']['payrollId'] = $payroll->id;
                    $availability['stage1Existed']['generatedDate'] = $payroll->generatedDate;
                    $availability['stage1Existed']['generatedby'] = $payroll->generatedBy;
                }
            }


            /* Insert to response array */
            $response['isFailed'] = false;
            $response['message'] = 'Success';
            $response['reports']['summary'] = fractal($generateSalaryReport, new PayrollGeneratedSalaryHistoryTransformer())->toArray()['data'];
            $response['reports']['details'] = $details;
            $response['reports']['availability'] = $availability;

            return response()->json($response, 200);

        } else { // Error response

            $response['isFailed'] = true;
            $response['message'] = 'Unable to find generate salary report';
            return response()->json($response, 200);

        }

    }


}