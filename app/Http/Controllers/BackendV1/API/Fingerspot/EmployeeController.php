<?php

namespace App\Http\Controllers\BackendV1\API\Fingerspot;

use App\Employee\Logics\EmployeeSearchLogic;
use App\Employee\Models\FingerspotUser;
use App\Employee\Models\MasterEmployee;
use App\Employee\Transformers\EmployeeNameAndIdTransfomer;
use App\Http\Controllers\BackendV1\API\Traits\ApiUtils;
use App\Http\Controllers\BackendV1\API\Traits\ResponseCodes;
use App\Http\Controllers\Controller;
use App\Traits\GlobalUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class EmployeeController extends Controller
{
    use GlobalUtils;
    use ApiUtils;

    /*
     * @url : /api/v1/a/fingerspot/register/user
     * @method : POST
     * @body : employeeId (string) , pin (string)
     * @response :
     *              {
     *                isFailed : false,
     *                code : 1,
     *                message : 'Success. Uses has been registered successfully',
     *                employee : {
     *                  id : '14c5c12b-5b8d-3577-9137-12ad99f2b52b',
     *                  employeeNo : '1234803321',
     *                  givenName : 'Joko',
     *                  surname : 'Widodo',
     *                }
     *              }
     */
    public function register(Request $request)
    {

        $response = array();

        $validator = Validator::make($request->all(), [
            'pin' => 'required',
            'employeeId' => 'required'
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$ERR_CODE['MISSING_PARAM'];
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $insert = FingerspotUser::updateOrCreate(
            [
                'employeeId' => $request->employeeId,
                'fingerspotUserId' => $request->pin
            ],
            [

            ]
        );

        if($insert){

            /* Success response */

            $response['isFailed'] = false;
            $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
            $response['message'] = 'Success. Uses has been registered successfully';
            $response['employee'] = fractal($insert->employee,new EmployeeNameAndIdTransfomer());
            return response()->json($response,200);

        } else {

            /* Error response */

            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$ERR_CODE['ELOQUENT_ERR'];
            $response['message'] = 'Unable to register new user';

            return response()->json($response,200);

        }
    }

    /*
        * @url : /api/v1/a/fingerspot/search/user?text=Joko
        * @method : POST
        * @param : text (string)
        * @response :
        *              {
        *                isFailed : false,
        *                code : 1,
        *                message : 'Success',
        *                candidates : [
        *                 {
        *                  id : '14c5c12b-5b8d-3577-9137-12ad99f2b52b',
        *                  employeeNo : '1234803321',
        *                  givenName : 'Joko',
        *                  surname : 'Widodo',
        *                },
        *                 {
        *                  id : '14c5c12b-5b8d-3577-9137-12ad99f2b52b',
        *                  employeeNo : '1234803321',
        *                  givenName : 'Joko',
        *                  surname : 'Widodo',
        *                },
        *                {
        *                  id : '14c5c12b-5b8d-3577-9137-12ad99f2b52b',
        *                  employeeNo : '1234803321',
        *                  givenName : 'Joko',
        *                  surname : 'Widodo',
        *                }
        *               ]
        *              }
        */
    public function search($text)
    {
        $candidatesEmployee = MasterEmployee::where('employeeNo', 'LIKE', '%' . $text . '%')
            ->orWhere('givenName', 'LIKE', '%' . $text . '%')
            ->orWhere('surname', 'LIKE', '%' . $text . '%')
            ->orWhere('nickName', 'LIKE', '%' . $text . '%')->get();

        $response = array();

        if ($candidatesEmployee != null && count($candidatesEmployee)>0) {

            $response['isFailed'] = false;
            $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
            $response['message'] = 'Success';
            $response['candidates'] = fractal($candidatesEmployee, new EmployeeNameAndIdTransfomer());

            return response()->json($response, 200);
        } else {
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$USER_ERR_CODE['USER_EMPLOYEE_DATA_NOT_FOUND'];
            $response['message'] = 'No employee found';

            return response()->json($response, 200);
        }
    }


}
