<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Salary;


use App\Components\Transformers\BasicSettingTrasnformer;
use App\Salary\Logics\Salary\GenerateSalaryLogic;
use App\Salary\Models\GenerateSalaryReportLogs;
use App\Salary\Models\PayrollSetting;
use App\Salary\Models\SalaryReport;
use App\Salary\Transformers\GeneratedSalaryLogsDetailsTransformer;
use App\Salary\Transformers\GeneratedSalaryLogsTransformer;
use App\Traits\GlobalUtils;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PayrollSettingController extends Controller
{

    use GlobalUtils;

    public function __construct()
    {
        $this->middleware(['permission:access salary']);
    }

    public function list()
    {
        $response = array();
        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['payrollSettings'] = fractal(PayrollSetting::all(), new BasicSettingTrasnformer());

        return response()->json($response, 200);
    }

    public function edit(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'value'=>'required'
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Required parameter is missing';
            return response()->json($response, 200);
        }

        //is valid

        $update = PayrollSetting::where('id',$request->id)->update(['value'=>$request->value]);

        if($update){
            $response['isFailed'] = false;
            $response['message'] = 'Payroll setting has been updated successfully';
            $response['payrollSetting'] =  fractal(PayrollSetting::find($request->id), new BasicSettingTrasnformer());
            return response()->json($response, 200);
        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to find update payroll setting';
            return response()->json($response, 200);
        }


    }

}
