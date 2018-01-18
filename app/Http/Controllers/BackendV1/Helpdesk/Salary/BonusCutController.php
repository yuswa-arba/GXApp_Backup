<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Salary;


use App\Salary\Models\EmployeeBonusesCuts;
use App\Salary\Models\GeneralBonusesCuts;
use App\Salary\Models\SalaryBonusCutType;
use App\Salary\Transformers\SalaryBonusCutTransformer;
use App\Traits\GlobalUtils;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class BonusCutController extends Controller
{

    use GlobalUtils;

    public function __construct()
    {
        $this->middleware(['permission:access salary']);
    }


    public function list()
    {
        $salaryBonusCut = SalaryBonusCutType::where('isDeleted','!=',1)->get();

        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['bonuscut'] = fractal($salaryBonusCut,new SalaryBonusCutTransformer());

        return response()->json($response,200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),['name'=>'required|unique:salaryBonusCutType','addOrSub'=>'required']);

        if($validator->fails()){
            $response['isFailed'] = true;
            $response['message'] = 'Name and add/sub is required and unique';
            return response()->json($response,200);
        }

        //is valid

        $create = SalaryBonusCutType::create($request->all());

        if($create){
            $response['isFailed'] = false;
            $response['message'] = 'Bonus/Cut has been created successfully';
            $response['bonuscut'] = fractal($create,new SalaryBonusCutTransformer());
            return response()->json($response,200);
        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to create bonus/cut';
            return response()->json($response,200);
        }
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(),['bonusCutTypeId'=>'required']);

        if($validator->fails()){
            $response['isFailed'] = true;
            $response['message'] = 'Bonus Cut Type Id is not defined';
            return response()->json($response,200);
        }

        //is valid

        //remove from employee bonus cut
        EmployeeBonusesCuts::where('salaryBonusCutTypeId',$request->bonusCutTypeId)->delete();

        //remove from general bonus cut
        GeneralBonusesCuts::where('salaryBonusCutTypeId',$request->bonusCutTypeId)->delete();

        $delete = SalaryBonusCutType::where('id',$request->bonusCutTypeId)->update(['isDeleted'=>1]);

        if($delete){
            $response['isFailed'] = false;
            $response['message'] = 'Bonus Cut Type has been deleted successfully';
            return response()->json($response,200);
        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Error! Unable to delete Bonus Cut Type';
            return response()->json($response,200);
        }

    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(),['bonusCutTypeId'=>'required','bonusCutName'=>'required']);

        if($validator->fails()){
            $response['isFailed'] = true;
            $response['message'] = 'Bonus Cut Type Id or name is not defined';
            return response()->json($response,200);
        }

        //is valid

        $update = SalaryBonusCutType::where('id',$request->bonusCutTypeId)->update(['name'=>$request->bonusCutName]);
        if($update){
            $response['isFailed'] = false;
            $response['message'] = 'Bonus Cut Type has been edited successfully';
            return response()->json($response,200);
        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Error! Unable to edit Bonus Cut Type';
            return response()->json($response,200);
        }

    }

}
