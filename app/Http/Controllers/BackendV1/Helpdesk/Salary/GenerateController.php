<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Salary;


use App\Salary\Logics\Salary\GenerateSalaryLogic;
use App\Salary\Models\GenerateSalaryReportLogs;
use App\Salary\Models\SalaryReport;
use App\Salary\Transformers\GeneratedSalaryLogsDetailsTransformer;
use App\Salary\Transformers\GeneratedSalaryLogsTransformer;
use App\Traits\GlobalUtils;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GenerateController extends Controller
{

    use GlobalUtils;

    public function __construct()
    {
//        $this->middleware(['permission:access salary']);
    }


    public function attemptGenerate(Request $request)
    {
        return GenerateSalaryLogic::attemptGenerate($request);
    }

    public function generate(Request $request)
    {
        return GenerateSalaryLogic::generate($request);
    }

    /*
     * @desc get generated salary logs
     * @return return GeneratedSalaryLogsTransformer()
     * */
    public function getLogs()
    {
        return fractal(GenerateSalaryReportLogs::all()->sortByDesc('created_at'), new GeneratedSalaryLogsTransformer());
    }

    public function getLogDetails($id)
    {
        
        $response = array();
        if ($id != null && $id != '') {

            $generatedLog = GenerateSalaryReportLogs::find($id);
            if ($generatedLog) {

                $salaryReports = SalaryReport::whereIn('id',explode(' ',$generatedLog->salaryReportIds))->get();

                if ($salaryReports) {

                    $response['isFailed'] = false;
                    $response['message'] = 'Success';
                    $response['salaryLogDetails'] = fractal($salaryReports, new GeneratedSalaryLogsDetailsTransformer());

                    return response()->json($response, 200);

                } else {
                    $response['isFailed'] = true;
                    $response['message'] = 'Unable to find details';
                    return response()->json($response, 200);
                }



            } else {
                $response['isFailed'] = false;
                $response['message'] = 'Unable to find generated salary report';
                return response()->json($response, 200);
            }
        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Required parameter ID';
            return response()->json($response, 200);
        }
    }

}
