<?php

namespace App\Http\Controllers\BackendV1\API\APK;

use App\Account\Traits\TokenUtils;
use App\Http\Controllers\BackendV1\API\Traits\ApiUtils;
use App\Http\Controllers\BackendV1\API\Traits\ResponseCodes;
use App\Http\Controllers\Controller;
use App\Traits\ApkConfig;
use App\Traits\GlobalUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
    use ApiUtils;
    use GlobalUtils;

    public function checkLatestVersion()
    {
        $response = array();

        if ($this->checkUserEmployee()) {

            $response['isFailed'] = false;
            $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
            $response['message'] = 'Success';
            $response['versionCode'] = ApkConfig::$APK_VERSION['LATEST_VERSION_CODE'];
            $response['versionName'] = ApkConfig::$APK_VERSION['LATEST_VERSION_NAME'];
            $response['versionDesc'] = ApkConfig::$APK_VERSION['LATEST_VERSION_DESC'];
            $response['forceDownload'] = ApkConfig::$IS_FORCE_UPDATE['FORCE'];

            return response()->json($response, 200);

        } else {

            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$USER_ERR_CODE['USER_ACCESS_NOT_GRANTED'];
            $response['message'] = 'User\'s access not granted';

            return response()->json($response, 200);
        }

    }

    public function download(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        switch ($request->type) {
            case ApkConfig::$DOWNLOAD_TYPE['LATEST']:
                //check if file exist
                $path = public_path(ApkConfig::$APK_PATH['LATEST']);
                if (file_exists($path)) {
                    $headers = [
                        'Content-Type' => 'application/vnd.android.package-archive',
                        'Content-Disposition' => 'attachment; filename="' . ApkConfig::$APK_NAME['LATEST'] . '"',
                    ];
                    return response()->download($path, ApkConfig::$APK_NAME['LATEST'], $headers);
                } else {
                    $response['isFailed'] = true;
                    $response['code'] = ResponseCodes::$APK_ERR_CODE['APK_NOT_FOUND'];
                    $response['message'] = 'File not found';
                    return response()->json($response, 200);
                }

                break;
            case ApkConfig::$DOWNLOAD_TYPE['PREVIOUS']:
                $path = public_path(ApkConfig::$APK_PATH['PREVIOUS']);
                if (file_exists($path)) { //return apk file
                    $headers = [
                        'Content-Type' => 'application/vnd.android.package-archive',
                        'Content-Disposition' => 'attachment; filename="' . ApkConfig::$APK_NAME['PREVIOUS'] . '"',
                    ];
                    return response()->download($path, ApkConfig::$APK_NAME['PREVIOUS'], $headers);
                } else { // return error response
                    $response['isFailed'] = true;
                    $response['code'] = ResponseCodes::$APK_ERR_CODE['APK_NOT_FOUND'];
                    $response['message'] = 'File not found';
                    return response()->json($response, 200);
                }
                break;
            case ApkConfig::$DOWNLOAD_TYPE['STABLE']:
                $path = public_path(ApkConfig::$APK_PATH['STABLE']);
                if (file_exists($path)) { //return apk file
                    $headers = [
                        'Content-Type' => 'application/vnd.android.package-archive',
                        'Content-Disposition' => 'attachment; filename="' . ApkConfig::$APK_NAME['STABLE'] . '"',
                    ];
                    return response()->download($path, ApkConfig::$APK_NAME['STABLE'], $headers);
                } else { // return error response
                    $response['isFailed'] = true;
                    $response['code'] = ResponseCodes::$APK_ERR_CODE['APK_NOT_FOUND'];
                    $response['message'] = 'File not found';
                    return response()->json($response, 200);
                }
                break;
            default:
                //check if file exist
                $pathLatest = public_path(ApkConfig::$APK_PATH['LATEST']);
                $pathStable = public_path(ApkConfig::$APK_PATH['STABLE']);
                $pathPrevious = public_path(ApkConfig::$APK_PATH['PREVIOUS']);


                // By default download the latest version
                // If not exist check for the stable version
                // If not exist check for the previous version
                // If not exist return error response
                if (file_exists($pathLatest)) {
                    $headers = [
                        'Content-Type' => 'application/vnd.android.package-archive',
                        'Content-Disposition' => 'attachment; filename="' . ApkConfig::$APK_NAME['LATEST'] . '"',
                    ];
                    return response()->download($pathLatest, ApkConfig::$APK_NAME['LATEST'], $headers);
                } else if (file_exists($pathStable)) {
                    $headers = [
                        'Content-Type' => 'application/vnd.android.package-archive',
                        'Content-Disposition' => 'attachment; filename="' . ApkConfig::$APK_NAME['STABLE'] . '"',
                    ];
                    return response()->download($pathStable, ApkConfig::$APK_NAME['STABLE'], $headers);
                } else if (file_exists($pathPrevious)) {
                    $headers = [
                        'Content-Type' => 'application/vnd.android.package-archive',
                        'Content-Disposition' => 'attachment; filename="' . ApkConfig::$APK_NAME['PREVIOUS'] . '"',
                    ];
                    return response()->download($pathPrevious, ApkConfig::$APK_NAME['PREVIOUS'], $headers);
                } else {
                    $response['isFailed'] = true;
                    $response['code'] = ResponseCodes::$APK_ERR_CODE['APK_NOT_FOUND'];
                    $response['message'] = 'File not found';
                    return response()->json($response, 200);
                }

                break;
        }

    }


    public function submitProblem()
    {
        //TODO apk download error/problem report
    }

}
