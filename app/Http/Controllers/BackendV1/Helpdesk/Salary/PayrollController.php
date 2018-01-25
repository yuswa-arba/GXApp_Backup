<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Salary;


use App\Components\Transformers\BasicSettingTrasnformer;
use App\Salary\Logics\Payroll\GeneratePayrollLogic;
use App\Salary\Logics\Salary\GenerateSalaryLogic;
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

    public function getGenerateSalaryHistory()
    {
        // get only current year and last year
        $generateSalaryReports = GenerateSalaryReportLogs::orderBy('id', 'desc')
            ->whereYear('created_at', Carbon::now()->year)->orWhere(function ($query) {
                $query->whereYear('created_at', Carbon::now()->subYear()->year);
            })->get();

        foreach ($generateSalaryReports as $generateSalaryReport){
            /* Salary Reports Data */
            $salaryReports = SalaryReport::whereIn('id', explode(' ', $generateSalaryReport->salaryReportIds))->get();

            /* Check */
            $this->checkStage2Confirm($generateSalaryReport, $salaryReports);
        }

        $response = array();
        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['reports'] = fractal($generateSalaryReports, new PayrollGeneratedSalaryHistoryTransformer())->toArray()['data'];

        return response()->json($response, 200);
    }

    public function attemptGenerate(Request $request)
    {
        return GeneratePayrollLogic::attemptGenerate($request);
    }


}
