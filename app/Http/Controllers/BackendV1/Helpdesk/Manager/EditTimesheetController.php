<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Manager;

use App\Components\Models\DivisionManager;
use App\Employee\Transformers\DivisionManagerTransformer;
use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use App\Http\Controllers\Controller;
use App\Manager\Logics\EditTimesheet\SummaryEditTimesheetLogic;
use App\Manager\Models\EditTimesheet;
use App\Manager\Transformers\EditTimesheetTransformer;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EditTimesheetController extends Controller
{
    use GlobalUtils;

    public function list(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(),
            []
        );

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $user = Auth::user();
        $employee = $user->employee;
        $manager = $employee->divisionManager;

        if ($manager != null) {
            $timesheets = EditTimesheet::where('divisionId', $manager->divisionId)
                ->where('branchOfficeId', $manager->branchOfficeId)
                ->orderBy('id', 'desc')
                ->get();

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            $response['timesheets'] = fractal($timesheets, new EditTimesheetTransformer());

            return response()->json($response, 200);
        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to get timesheet data';
            return response()->json($response, 200);
        }


    }

    public function summary(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), [
            'editTimesheetId' => 'required'
        ]);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $editTimesheet = EditTimesheet::find($request->editTimesheetId);

        if ($editTimesheet) {

            /* run logic */
            return SummaryEditTimesheetLogic::getData($editTimesheet);

        } else {

            /* Error response */
            $response['isFailed'] = true;
            $response['message'] = 'Unable to find edit timesheet data';
            return response()->json($response, 200);
        }

    }

    public function generateAndSend(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(),
            [
                'dueDate' => 'required',
                'startDate' => 'required',
                'endDate' => 'required',
                'branchOfficeId' => 'required'
            ]
        );

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $getDivisions = DivisionManager::select('divisionId')
            ->where('branchOfficeId', $request->branchOfficeId)
            ->get()
            ->toArray();

        $divisionIds = array_unique(array_column($getDivisions, 'divisionId'));

        if (count($divisionIds) > 0) {

            foreach ($divisionIds as $divisionId) {

                EditTimesheet::updateOrCreate(
                    [
                        'divisionId' => $divisionId,
                        'branchOfficeId' => $request->branchOfficeId
                    ],
                    [
                        'startDate' => $request->startDate,
                        'endDate' => $request->endDate,
                        'dueDate' => $request->dueDate,
                        'generatedAt' => Carbon::now()->format('d/m/Y'),
                        'generatedBy' => $this->getResultWithNullChecker1Connection(Auth::user(), 'employee', 'givenName')
                    ]
                );

                /* send notification to manager */
                $divisionManager = DivisionManager::where('divisionId', $divisionId)
                    ->where('branchOfficeId', $request->branchOfficeId)
                    ->where('isActive', 1)
                    ->first();

                if ($divisionManager) {
                    $managerUserId = $this->getResultWithNullChecker2Connection($divisionManager, 'employee', 'user', 'id');
                    if ($managerUserId != null && $managerUserId != '') {
                        /* Send push notification */
                        app()->make('PushNotificationService')->singleNotify(array(
                            'userID' => $managerUserId,
                            'title' => 'Edit Timesheet',
                            'message' => 'Attendance timesheet is available, you may edit your team attendance before the due date.',
                            'intentType' => ConfigCodes::$FCM_INTENT_TYPE['HOME'],
                            'viaType' => ConfigCodes::$NOTIFY_TYPE['NOTIFICATION'],
                            'sender' => Auth::user()
                        ));
                    }
                }


            }

            /* Success response */
            $response['isFailed'] = false;
            $response['message'] = 'Success. Timesheet has been sent successfully';
            return response()->json($response, 200);

        } else {

            /* Error response */
            $response['isFailed'] = true;
            $response['message'] = 'No division manager found';
            return response()->json($response, 200);
        }
    }
}
