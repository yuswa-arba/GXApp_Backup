<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Profile;


use App\Employee\Transformers\EmployeeBriefDetailTransfomer;
use App\Employee\Transformers\EmployeeListTransfomer;
use App\Http\Controllers\Controller;
use App\Notification\Models\NotificationGroupType;
use App\Notification\Models\NotificationRecipientGroup;
use App\Notification\Models\Notifications;
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
                ->where('hasSeen',0)
//                ->orderBy('hasSeen', 'asc')
                ->orderBy('created_at', 'desc')
                ->take(6)->get();

            foreach ($notification as $n => $notif) {

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


    public function seenNotificationList()
    {
        $response = array();

        $user = Auth::user();
        $seenNotification = Notifications::where('userId', $user->id)->where('hasSeen', 0)->update(
            [
                'hasSeen' => 1,
                'seenDate'=>Carbon::now()->format('d/m/Y'),
                'seenTime'=>Carbon::now()->format('H:i')
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


}
