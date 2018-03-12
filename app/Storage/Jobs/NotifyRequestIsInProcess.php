<?php
namespace App\Storage\Jobs;

use App\Account\Models\User;
use App\Attendance\Models\AttendanceSchedule;
use App\Attendance\Models\Shifts;
use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use App\Mail\NewStorageRequisitions;
use App\Notification\Models\NotificationRecipientGroup;
use App\Storage\Models\StorageRequisition;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 18/12/17
 * Time: 6:37 PM
 */
class NotifyRequestIsInProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 10;

    public $requisitionId;
    public $user;

    public function __construct($requisitionId,$user)
    {
        $this->requisitionId = $requisitionId;
        $this->user = $user;
    }

    /**
     * Send notification to admins that there is new requisition
     */
    public function handle()
    {
        // Get requisition
        $requisition = StorageRequisition::find($this->requisitionId);

        // Get User Ids of recipients
        $recipientsUser = User::select('id', 'email')->where('employeeId', $requisition->requesterEmployeeId)->first();

        /* Send push notification */
        app()->make('PushNotificationService')->singleNotify([
            'userID' => $recipientsUser->id,
            'title' => 'Requisition Tracking ',
            'message' => 'Your requisition is being processed #' . $requisition->requisitionNumber,
            'url' => '',
            'intentType' => ConfigCodes::$FCM_INTENT_TYPE['HOME'],
            'viaType' => ConfigCodes::$NOTIFY_TYPE['NOTIFICATION'],
            'groupTypeId'=>4,// New requisition group type Id
            'sender' => $this->user
        ]);

        /* Send email */
        //TODO : activate when on production
        try {
//                $message = (new NewStorageRequisitions($this->requisitionId))->onConnection('database')->onQueue('emails');
//                Mail::to($recipient->email)->queue($message);
        } catch (\Exception $exception) {
            // Do nothing
        }

    }

}