<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Employee;

use App\Components\Models\Division;
use App\Components\Models\DivisionManager;
use App\Employee\Logics\EmployeeSearchLogic;
use App\Employee\Models\MasterEmployee;
use App\Employee\Transformers\DivisionManagerTransformer;
use App\Employee\Transformers\EmployeeListTransfomer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ManagersController extends Controller
{

    public function list()
    {

        $response = array();

        $managers = DivisionManager::all();

        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['managers'] = fractal($managers, new DivisionManagerTransformer());

        return response()->json($response, 200);

    }


    public function assign(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'employeeId' => 'required',
            'divisionId' => 'required'
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $insert = DivisionManager::updateOrCreate(
            [
                'employeeId' => $request->employeeId,
                'divisionId' => $request->divisionId
            ],
            []
        );

        if ($insert) {

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            $response['manager'] = fractal($insert, new DivisionManagerTransformer());

            return response()->json($response, 200);
        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to save data';

            return response()->json($response, 200);
        }


    }

    public function activate(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), ['divisionManagerId' => 'required']);


        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $divisionManager = DivisionManager::find($request->divisionManagerId);

        if ($divisionManager) {

            $divisionManager->isActive = 1;
            $divisionManager->startDate = Carbon::now()->format('d/m/Y');
            $divisionManager->endDate = '';

            //save
            if ($divisionManager->save()) {
                $response['isFailed'] = false;
                $response['message'] = 'Success';

                return response()->json($response, 200);
            } else {
                $response['isFailed'] = true;
                $response['message'] = 'Unable to activate division manager';
                return response()->json($response,200);
            }


        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to find division manager';
            return response()->json($response, 200);
        }

    }

    public function deactivate(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), ['divisionManagerId' => 'required']);


        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $divisionManager = DivisionManager::find($request->divisionManagerId);

        if ($divisionManager) {

            $divisionManager->isActive = 0;
            $divisionManager->endDate = Carbon::now()->format('d/m/Y');

            //save
            if ($divisionManager->save()) {
                $response['isFailed'] = false;
                $response['message'] = 'Success';

                return response()->json($response, 200);
            } else {
                $response['isFailed'] = true;
                $response['message'] = 'Unable to activate division manager';
                return response()->json($response,200);
            }


        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to find division manager';
            return response()->json($response, 200);
        }


    }
}
