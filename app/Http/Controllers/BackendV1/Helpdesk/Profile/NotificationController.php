<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Profile;


use App\Components\Transformers\BasicComponentTrasnformer;
use App\Employee\Transformers\EmployeeBriefDetailTransfomer;
use App\Employee\Transformers\EmployeeListTransfomer;
use App\Http\Controllers\Controller;
use App\Notification\Models\NotificationGroupType;
use App\Notification\Models\NotificationRecipientGroup;
use App\Notification\Models\Notifications;
use App\Notification\Transformers\NotificationListTransformer;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class NotificationController extends Controller
{

    use GlobalUtils;

    public function getNotificationList()
    {
        $response = array();

        $user = Auth::user();
        $employee = $user->employee;

        $groupTypeIds = array();

        //Add general group type
        array_push($groupTypeIds, 1); // General group type

        //Add specific group type IDs that is added by admin
        $recipientsOfGroupTypeIds = NotificationRecipientGroup::where('employeeId', $employee->id)->get()->pluck('groupTypeId');
        foreach ($recipientsOfGroupTypeIds as $recipientsOfGroupTypeId) {
            array_push($groupTypeIds, $recipientsOfGroupTypeId);
        }

        // Remove duplicated
        $groupTypeIds = array_unique($groupTypeIds);

        $notificationList = array();

        foreach ($groupTypeIds as $g => $groupTypeId) {

            $notificationList[$g]['groupTypeId'] = $groupTypeId;
            $notificationList[$g]['groupTypeName'] = NotificationGroupType::find($groupTypeId)->name;
            $notificationList[$g]['totalNew'] = Notifications::where('userId', $user->id)->where('groupTypeId', $groupTypeId)->where('hasSeen', 0)->count();

            //Only get unread notifications
            $notification = Notifications::where('userId', $user->id)
                ->where('groupTypeId', $groupTypeId)
                ->where('hasSeen', 0)
//                ->orderBy('hasSeen', 'asc')
                ->orderBy('created_at', 'desc')
                ->take(6)->get();

            foreach ($notification as $n => $notif) {

                $notificationList[$g]['notifData'][$n]['id'] = $notif->id;
                $notificationList[$g]['notifData'][$n]['title'] = $notif->title;
                $notificationList[$g]['notifData'][$n]['message'] = $notif->message;
                $notificationList[$g]['notifData'][$n]['url'] = $notif->url;
                $notificationList[$g]['notifData'][$n]['sendBy'] = $notif->sendBy;
                $notificationList[$g]['notifData'][$n]['sendAt'] = $notif->sendDate . ' ' . $notif->sendTime;
                $notificationList[$g]['notifData'][$n]['hasSeen'] = $notif->hasSeen;
            }

        }

        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['notifications'] = $notificationList;

        $unreadExist = false;

        if (Notifications::where('userId', $user->id)->where('hasSeen', 0)->count() > 0) {
            $unreadExist = true;
        }
        $response['unreadExists'] = $unreadExist;

        return response()->json($response, 200);

    }

    public function getNotificationListOfGroupType(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), ['groupTypeId' => 'required']);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $user = Auth::user();
        $month = Carbon::now()->month;
        $year  = Carbon::now()->year;

        if ($request->month) {
            $month = $request->month;
        }

        if($request->year){
            $year = $request->year;
        }

        // get notifications
        $notifications = Notifications::where('userId', $user->id)
            ->where('groupTypeId', $request->groupTypeId)
//            ->where('sendDate', $date)
            ->whereMonth('created_at',$month)
            ->whereYear('created_at',$year)
            ->orderBy('hasSeen', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['notifications'] = fractal($notifications,new NotificationListTransformer());

        return response()->json($response,200);
    }

    public function getRecipientGroups()
    {
        $response = array();

        $user = Auth::user();
        $employee = $user->employee;

        if($employee){
            $groupTypeIds = array();

            //Add general group type
            array_push($groupTypeIds, 1); // General group type

            //Add specific group type IDs that is added by admin
            $recipientsOfGroupTypeIds = NotificationRecipientGroup::where('employeeId', $employee->id)->get()->pluck('groupTypeId');
            foreach ($recipientsOfGroupTypeIds as $recipientsOfGroupTypeId) {
                array_push($groupTypeIds, $recipientsOfGroupTypeId);
            }

            // Remove duplicated
            $groupTypeIds = array_unique($groupTypeIds);

            $groupTypes = array();

            foreach ($groupTypeIds as $g => $groupTypeId) {

                $groupTypes[$g]['id'] = $groupTypeId;
                $groupTypes[$g]['name'] = NotificationGroupType::find($groupTypeId)->name;
                $groupTypes[$g]['totalNew'] = Notifications::where('userId', $user->id)->where('groupTypeId', $groupTypeId)->where('hasSeen', 0)->count();
            }

            /* Success repsonse */
            $response['isFailed'] = false;
            $response['message'] = 'Success';
            $response['groupTypes'] = $groupTypes;

            return response()->json($response,200);


        } else {

            /* Error response */
            $response['isFailed'] = true;
            $response['message'] = 'Unable to get employee data';
            return response()->json($response,200);
        }

    }


    public function seenAllNotification()
    {
        $response = array();

        $user = Auth::user();
        $seenNotification = Notifications::where('userId', $user->id)->where('hasSeen', 0)->update(
            [
                'hasSeen' => 1,
                'seenDate' => Carbon::now()->format('d/m/Y'),
                'seenTime' => Carbon::now()->format('H:i')
            ]
        );

        if ($seenNotification) {

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to update seen notification';
            return response()->json($response, 200);
        }

    }

    public function seenNotification(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), ['notificationId' => 'required']);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }


        //is valid

        $notification = Notifications::find($request->notificationId);

        if ($notification) {

            $notification->hasSeen = 1;
            $notification->seenDate = Carbon::now()->format('d/m/Y');
            $notification->seenTime = Carbon::now()->format('H:i');

            if ($notification->save()) {

                $response['isFailed'] = false;
                $response['message'] = 'Success';

                return response()->json($response, 200);

            } else {
                $response['isFailed'] = true;
                $response['message'] = 'Unable to save data';

                return response()->json($response, 200);
            }

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to find notification data';
            return response()->json($response, 200);
        }


    }


}
