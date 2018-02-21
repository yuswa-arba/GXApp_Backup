<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Settings;


use App\Components\Transformers\BasicComponentTrasnformer;
use App\Components\Transformers\BasicSettingTrasnformer;
use App\Employee\Models\MasterEmployee;
use App\Http\Controllers\Controller;
use App\Notification\Models\NotificationGroupType;
use App\Notification\Models\NotificationRecipientGroup;
use App\Notification\Transformers\NotificationRecipientTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:edit setting']);
    }

    public function addNotificationRecipient(Request $request)
    {

        $response = array();

        $validator = Validator::make($request->all(), [
            'employeeId' => 'required',
            'groupTypeId' => 'required'
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        $employee = MasterEmployee::find($request->employeeId);


        if ($employee) {

            if ($employee->hasResigned) { // check if employee has resigned
                $response['isFailed'] = true;
                $response['message'] = 'Unable to save data, employee has resigned';
                return response()->json($response, 200);
            }

            //is valid

            $insert = NotificationRecipientGroup::updateOrCreate(
                [
                    'employeeId' => $request->employeeId,
                    'groupTypeId' => $request->groupTypeId
                ],
                []
            );

            if($insert){ /* Success response */

                $response['isFailed'] = false;
                $response['message'] = 'Success';
                $response['recipient'] = fractal($insert, new NotificationRecipientTransformer());

                return response()->json($response,200);

            } else { /* Error response */
                $response['isFailed'] = true;
                $response['message'] = 'Unable to save recipient';
                return response()->json($response,200);
            }


        } else { /* Error response */
            $response['isFailed'] = true;
            $response['message'] = 'Unable to find employee data';
            return response()->json($response, 200);
        }


    }

    public function addGroupType(Request $request)
    {

        $response = array();

        $user = Auth::user();

        if ($user->hasRole('developer')) {


            $validator = Validator::make($request->all(), ['name' => 'required']);

            if ($validator->fails()) {  /* ERror response */

                $response['isFailed'] = true;
                $response['message'] = 'Missing required parameters';
                return response()->json($response, 200);
            }

            //is valid

           $create =  NotificationGroupType::create(['name' => $request->name]);

            /* Success response */

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            $response['groupType'] = fractal($create,new BasicComponentTrasnformer());
            return response()->json($response, 200);


        } else { /* Error response */
            $response['isFailed'] = true;
            $response['message'] = 'Unauthorize to create group type';
            return response()->json($response, 200);
        }
    }

}
