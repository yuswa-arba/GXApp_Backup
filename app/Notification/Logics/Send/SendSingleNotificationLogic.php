<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Notification\Logics\Send;


use App\Account\Events\UserNotified;
use App\Http\Controllers\BackendV1\Helpdesk\Traits\Configs;
use App\Notification\Models\Notifications;
use App\Employee\Models\MasterEmployee;
use App\Traits\FirebaseUtils;
use App\Traits\GlobalConst;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;


class SendSingleNotificationLogic extends SendSingleNotificationUseCase
{

    use GlobalUtils;
    use FirebaseUtils;

    /*
     * @description send notification
     * */


    public function handleSendViaNotification($request)
    {

        $response = array();
        $employee = MasterEmployee::find($request->employeeId);

        if ($employee && $employee->user->id) {

            $notification = Notifications::create([
                'userId' => $employee->user->id,
                'title' => $request->title,
                'message' => $request->message,
                'intentType' => $request->intentType,
                'url' => $request->url,
                'viaType' => $request->viaType,
                'sendBy' => $this->getResultWithNullChecker1Connection(Auth::user(), 'employee', 'givenName'),
                'sendDate' => Carbon::now()->format('d/m/Y'),
                'sendTime' => Carbon::now()->format('H:i')
            ]);

            if ($notification) {

                //EVENT BROADCAST ECHO (FOR WEB)
                broadcast(new UserNotified($employee->id, $notification->id))->toOthers();

                //FIREBASE PUSH NOTIFICATION
                $this->sendSinglePush(
                    $employee->user->id,
                    $request->title,
                    $request->message,
                    null,
                    $request->intentType
                );

            }


            $response['isFailed'] = false;
            $response['message'] = 'Success';
            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Employee not found';
            return response()->json($response, 200);
        }

    }

    public function handleSendViaSMS($request)
    {
        $response = array();
        $employee = MasterEmployee::find($request->employeeId);

        if ($employee && $employee->user->id) {

            $notification = Notifications::create([
                'userId' => $employee->user->id,
                'title' => $request->title,
                'message' => $request->message,
                'intentType' => $request->intentType,
                'url' => $request->url,
                'viaType' => $request->viaType,
                'sendBy' => $this->getResultWithNullChecker1Connection(Auth::user(), 'employee', 'givenName'),
                'sendDate' => Carbon::now()->format('d/m/Y'),
                'sendTime' => Carbon::now()->format('H:i')
            ]);

            if ($notification) {

                //send via sms
                $smsFile = base_path(Configs::$FILES['SMS_EXP']);

                if (file_exists($smsFile)) {
                    $content = file_get_contents($smsFile);
                    $content = str_replace('[message]',$request->message,$content);
                    $content = str_replace('[phoneNumber]',$employee->phoneNo,$content);

                    $file= base_path(Configs::$FILE_PATH['SMS_TO_SEND'].$employee->phoneNo.'.exp');
                    /* Create SMS File*/
                    $fp = fopen($file, 'w')or die('Cannot open file:  '.$file);

                    fwrite($fp, $content);
                    fclose($fp);


                    chmod($file, 0777);

                    $command = "cd ".base_path(Configs::$FILE_PATH['SMS_TO_SEND'])." && ./".$employee->phoneNo.".exp"; // cd /root/path/to/public/script/sms/ && ./08123123213.exp
                    $directory = base_path();
                    $process = new Process($command);
                    $process->setTimeout(3600);
                    $process->setIdleTimeout(300);
                    $process->setWorkingDirectory($directory);
                    try {
                        $process->mustRun();
                    } catch (ProcessFailedException $e) {
                        Log::error($e->getMessage());
                    }

                    unlink($file);


                }


            }


            $response['isFailed'] = false;
            $response['message'] = 'Success';
            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Employee not found';
            return response()->json($response, 200);
        }
    }
}