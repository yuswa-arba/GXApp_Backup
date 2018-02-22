<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Profile;


use App\Employee\Transformers\EmployeeBriefDetailTransfomer;
use App\Employee\Transformers\EmployeeListTransfomer;
use App\Http\Controllers\Controller;
use App\Notification\Models\NotificationGroupType;
use App\Notification\Models\NotificationRecipientGroup;
use App\Notification\Models\Notifications;
use App\Traits\GlobalUtils;
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

        $groupTypeIds =  array();

        //Add general group type
        array_push($groupTypeIds, 1); // General group type

        //Add specific group type IDs that is added by admin
        $recipientsOfGroupTypeIds = NotificationRecipientGroup::where('employeeId', $employee->id)->get()->pluck('groupTypeId');
        foreach ($recipientsOfGroupTypeIds as $recipientsOfGroupTypeId){
            array_push($groupTypeIds,$recipientsOfGroupTypeId);
        }

        // Remove duplicated
        $groupTypeIds = array_unique($groupTypeIds);

        $notificationList = array();

        foreach ($groupTypeIds as $g => $groupTypeId) {

            $notificationList[$g]['groupTypeId'] = $groupTypeId;
            $notificationList[$g]['groupTypeName'] = NotificationGroupType::find($groupTypeId)->name;

            $notification = Notifications::where('userId',$user->id)->where('groupTypeId',$groupTypeId)
                ->orderBy('hasSeen','asc')
                ->orderBy('created_at','desc')
                ->take(5)->get();

            foreach ($notification as $n => $notif){

                $notificationList[$g]['notifData'][$n]['title'] = $notif->title;
                $notificationList[$g]['notifData'][$n]['message'] = $notif->message;
                $notificationList[$g]['notifData'][$n]['url'] = $notif->url;
                $notificationList[$g]['notifData'][$n]['sendBy'] = $notif->sendBy;
                $notificationList[$g]['notifData'][$n]['sendAt'] = $notif->sendDate.' '.$notif->sendTime;
                $notificationList[$g]['notifData'][$n]['hasSeen'] = $notif->hasSeen;
            }

        }

        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['notifications'] = $notificationList;

        return response()->json($response,200);

    }



}
