<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Salary;


use App\Salary\Models\GeneralBonusesCuts;
use App\Salary\Models\SalaryBonusCutType;
use App\Salary\Transformers\GeneralBonusCutTransformer;
use App\Salary\Transformers\SalaryBonusCutTransformer;
use App\Traits\GlobalUtils;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class GeneralBonusCutController extends Controller
{

    use GlobalUtils;

    public function __construct()
    {
        $this->middleware(['permission:access salary']);
    }

    /* @desc: Get bonus cut list that is not yet being used in general bonus cut */

    public function bonusCutList()
    {

        $usedBonusCut = GeneralBonusesCuts::all()->pluck('salaryBonusCutTypeId');

        $salaryBonusCut = SalaryBonusCutType::where('isDeleted', '!=', 1)->whereNotIn('id', $usedBonusCut)->get();

        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['bonuscut'] = fractal($salaryBonusCut, new SalaryBonusCutTransformer());

        return response()->json($response, 200);
    }

    public function list()
    {
        $generalBonusCut = GeneralBonusesCuts::all();

        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['generalBC'] = fractal($generalBonusCut, new GeneralBonusCutTransformer());

        return response()->json($response, 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), ['bonusCutTypeId' => 'required']);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Required parameter is missing';
            return response()->json($response, 200);
        }


        $check = GeneralBonusesCuts::where('salaryBonusCutTypeId', $request->bonusCutTypeId)->count();
        if ($check > 0) {
            $response['isFailed'] = true;
            $response['message'] = 'Error! Bonus cut has been used once';
            return response()->json($response, 200);
        }

        //is valid

        $requestData = array();
        $requestData['salaryBonusCutTypeId'] = $request->bonusCutTypeId;

        $create = GeneralBonusesCuts::create($requestData);
        if ($create) {
            $response['isFailed'] = false;
            $response['message'] = 'General Bonus Cut has been created successfully';
            $response['generalBC'] = fractal($create, new GeneralBonusCutTransformer());
            return response()->json($response, 200);
        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Error! Unable to create general bonus cut';
            return response()->json($response, 200);
        }
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), ['generalBonusCutId' => 'required']);

        if ($request->isUsingFormula) {
            $validator = Validator::make($request->all(), [
                'generalBonusCutId' => 'required',
                'formula' => 'required'
            ]);

            /* Emptying value*/
            $request->value = "";


        } else {
            $validator = Validator::make($request->all(), [
                'generalBonusCutId' => 'required',
                'value' => 'required'
            ]);

            /* Emptying formula*/
            $request->formula = "";
        }

        //is valid

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Required parameter is missing';
            return response()->json($response, 200);
        }

        /* Get general bonus cut model */
        $generalBonusCut = GeneralBonusesCuts::find($request->generalBonusCutId);

        if ($generalBonusCut) {

            // update to database
            $update = $generalBonusCut->update([
                'isUsingFormula' => $request->isUsingFormula,
                'formula' => $request->formula,
                'value' => $request->value,
                'isActive' => $request->isActive
            ]);

            if ($update) {
                /* Success now return response with data */
                $response['isFailed'] = false;
                $response['message'] = 'General bonus cut has been edited successfully';
                $response['generalBC'] = fractal($generalBonusCut, new GeneralBonusCutTransformer());
                return response()->json($response, 200);

            } else {

                /* Return error response */

                $response['isFailed'] = true;
                $response['message'] = 'Unable to edit general bonus cut';
                return response()->json($response, 200);
            }

        } else {
            /* Return error response */

            $response['isFailed'] = true;
            $response['message'] = 'General bonus cut not found';
            return response()->json($response, 200);
        }
    }


}
