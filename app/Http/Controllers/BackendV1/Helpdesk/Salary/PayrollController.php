<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Salary;


use App\Components\Transformers\BasicSettingTrasnformer;
use App\Salary\Logics\Payroll\GeneratePayrollLogic;
use App\Salary\Logics\Payroll\GetPayrollListLogic;
use App\Salary\Logics\Payroll\GetSalaryReportDetailsLogic;
use App\Salary\Logics\Payroll\GetSalaryReportListLogic;
use App\Salary\Logics\Salary\GenerateSalaryLogic;
use App\Salary\Models\GeneratePayroll;
use App\Salary\Models\GenerateSalaryReportLogs;
use App\Salary\Models\PayrollSetting;
use App\Salary\Models\SalaryReport;
use App\Salary\Traits\SalaryCheckerUtil;
use App\Salary\Transformers\GeneratedSalaryLogsDetailsTransformer;
use App\Salary\Transformers\GeneratedSalaryLogsTransformer;
use App\Salary\Transformers\PayrollGeneratedSalaryHistoryTransformer;
use App\Traits\GlobalUtils;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PayrollController extends Controller
{

    use GlobalUtils;
    use SalaryCheckerUtil;

    public function __construct()
    {
//        $this->middleware(['permission:access salary']);
    }

    public function list(Request $request)
    {
        return GetPayrollListLogic::getData($request);
    }

    public function getGenerateSalaryHistory(Request $request)
    {
        return GetSalaryReportListLogic::getData($request);
    }

    public function details($salaryReportLogId)
    {
        $response = array();

        if ($salaryReportLogId == null || $salaryReportLogId == '') {
            $response['isFailed'] = true;
            $response['message'] = 'Salary report log ID is missing';
            return response()->json($response, 200);
        }


        return GetSalaryReportDetailsLogic::getData($salaryReportLogId);
    }

    public function refresh($salaryReportLogId)
    {
        $response = array();

        if ($salaryReportLogId == null || $salaryReportLogId == '') {
            $response['isFailed'] = true;
            $response['message'] = 'Salary report log ID is missing';
            return response()->json($response, 200);
        }

        //is valid

        $generatedSalaryReport = GenerateSalaryReportLogs::find($salaryReportLogId);

        if($generatedSalaryReport){

            /* Salary Reports Data */
            $salaryReports = SalaryReport::whereIn('id', explode(' ', $generatedSalaryReport->salaryReportIds))->get();

            /* Check */
            $this->checkStage2Confirm($generatedSalaryReport, $salaryReports);

            /* Return response */
            $response['isFailed'] = false;
            $response['message'] = 'Refresh successful!';
            $response['reports'] = fractal($generatedSalaryReport, new PayrollGeneratedSalaryHistoryTransformer())->toArray()['data'];

            return response()->json($response, 200);


        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Salary report log is empty';
            return response()->json($response,200);
        }
    }

    public function getLastGeneratedPayroll()
    {
        $response = array();
        $lastGeneratedPayrollData = array();

        $lastGeneratedPayroll = GeneratePayroll::orderBy('id','desc')->first();

        if($lastGeneratedPayroll){
            $lastGeneratedPayrollData['id'] = $lastGeneratedPayroll->id;
            $lastGeneratedPayrollData['fromDate'] = $lastGeneratedPayroll->fromDate;
            $lastGeneratedPayrollData['toDate'] = $lastGeneratedPayroll->toDate;
            $lastGeneratedPayrollData['branchOfficeId'] = $lastGeneratedPayroll->branchOfficeId;
            $lastGeneratedPayrollData['branchOfficeName'] = $this->getResultWithNullChecker1Connection($lastGeneratedPayroll,'branchOffice','name');
            $lastGeneratedPayrollData['generatedDate']= $lastGeneratedPayroll->generatedDate;
            $lastGeneratedPayrollData['generatedBy']= $lastGeneratedPayroll->generatedBy;
            $lastGeneratedPayrollData['generatedType']= $lastGeneratedPayroll->generatedType;
            $lastGeneratedPayrollData['totalEmployee']= $lastGeneratedPayroll->totalEmployee;
            $lastGeneratedPayrollData['notes']= $lastGeneratedPayroll->notes;
            $lastGeneratedPayrollData['generateSalaryReportLogId']= $lastGeneratedPayroll->generateSalaryReportLogId;

            /* return response */
            $response['isFailed'] = false;
            $response['message'] = 'Success';
            $response['lastGeneratedPayroll'] = $lastGeneratedPayrollData;

            return response()->json($response,200);
        } else {
            /* return response */
            $response['isFailed'] = true;
            $response['message'] = 'Date empty';

            return response()->json($response,200);
        }
    }

    public function attemptGenerate(Request $request)
    {
        return GeneratePayrollLogic::attemptGenerate($request);
    }

    public function generate(Request $request)
    {
        return GeneratePayrollLogic::generate($request);
    }

}
