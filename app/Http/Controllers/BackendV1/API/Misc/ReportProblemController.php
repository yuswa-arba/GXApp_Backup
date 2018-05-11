<?php

namespace App\Http\Controllers\BackendV1\API\Misc;


use App\Attendance\Transformers\ReportProblemTransformer;
use App\Http\Controllers\Controller;
use App\ReportProblem\Models\ReportProblem;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ReportProblemController extends Controller
{

    use GlobalUtils;
    public function __construct()
    {

    }


    public function getList(Request $request)
    {

        $response = array();

        $whereDate =Carbon::createFromFormat('d/m/Y',Carbon::now()->format('d/m/Y'));

        if($request->whereDate!=null&&$request->whereDate!=''){
            $whereDate =  Carbon::createFromFormat('d/m/Y',$request->whereDate);
        }
        //is valid

        // Star Convert date

        $starttoday = $whereDate->format('Y-m-d 00:00:01'); //sql format
        $endtoday   = $whereDate->format('Y-m-d 23:59:59'); //sql format
        // End Convert date

        $reportProblems = ReportProblem::where('created_at', '>=', $starttoday)->where('created_at', '<=', $endtoday)->orderBy('id','DESC')->get();

        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['reportProblems'] = fractal($reportProblems,new ReportProblemTransformer());

        return response()->json($response,200);
    }

    public function submit(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'typeId' => 'required',
            'problem' => 'required'
        ]);

        if($validator->fails()){
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameteres';
            return response()->json($response,200);
        }

        //is valid

        $from  = $this->getResultWithNullChecker1Connection(Auth::user(),'employee','givenName');

        $insert =  ReportProblem::create([
            'from'=>$from,
            'typeId'=>$request->typeId,
            'problem'=>$request->problem
        ]);

        if($insert){
            $response['isFailed'] = false;
            $response['message'] = 'Successful';
            return response()->json($response,200);
        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to insert data';
            return response()->json($response,200);
        }
    }

    public function update(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'reportProblemId' => 'required'
        ]);

        if($validator->fails()){
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameteres';
            return response()->json($response,200);
        }

        //is valid

        $update = ReportProblem::where('id',$request->reportProblemId)->update([
            'isSolved'=>$request->isSolved,
            'solution'=>$request->solution
        ]);

        if($update){
            $response['isFailed'] = false;
            $response['message'] = 'Successful';
            return response()->json($response,200);
        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to insert data';
            return response()->json($response,200);
        }

    }

}
