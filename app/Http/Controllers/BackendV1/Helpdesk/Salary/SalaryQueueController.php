<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Salary;


use App\Salary\Logics\Salary\GenerateSalaryLogic;
use App\Salary\Models\GenerateSalaryReportLogs;
use App\Salary\Models\SalaryQueue;
use App\Salary\Models\SalaryReport;
use App\Salary\Transformers\GeneratedSalaryLogsDetailsTransformer;
use App\Salary\Transformers\GeneratedSalaryLogsTransformer;
use App\Salary\Transformers\SalaryQueueTransformer;
use App\Traits\GlobalUtils;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalaryQueueController extends Controller
{

    use GlobalUtils;

    public function __construct()
    {
//        $this->middleware(['permission:access salary']);
    }


    public function list()
    {

        $salaryQueueus = SalaryQueue::all();

        $response = array();
        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['salaryQueues']=  fractal($salaryQueueus,new SalaryQueueTransformer());

        return response()->json($response,200);
    }


}
