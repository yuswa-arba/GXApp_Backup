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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $response['salaryQueues'] = fractal($salaryQueueus, new SalaryQueueTransformer());

        return response()->json($response, 200);
    }

    public function create(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'employeeId' => 'required',
            'salaryBonusCutTypeId' => 'required',
            'value' => 'required',
            'notes' => 'required'
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Required parameter is missing';
            return response()->json($response, 200);
        }

        //is valid

        $create = SalaryQueue::create([
            'employeeId'=>$request->employeeId,
            'salaryBonusCutTypeId'=>$request->salaryBonusCutTypeId,
            'value'=>$request->value,
            'notes'=>$request->notes,
            'insertedDate'=>Carbon::now()->format('d/m/Y'),
            'insertedBy'=>$this->getResultWithNullChecker1Connection(Auth::user(),'employee','givenName')
        ]);

        if($create){
            $response['isFailed'] = false;
            $response['message'] = 'Success';
            $response['salaryQueues'] = fractal($create, new SalaryQueueTransformer());
            return response()->json($response,200);
        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to create salary queue';
            return response()->json($response, 200);
        }

    }


}
