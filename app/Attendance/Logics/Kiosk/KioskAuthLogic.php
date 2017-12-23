<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 23/12/17
 * Time: 3:15 PM
 */

namespace App\Attendance\Logics\Kiosk;

use App\Attendance\Models\KioskActivity;
use App\Attendance\Models\Kiosks;
use App\Http\Controllers\BackendV1\API\Traits\ResponseCodes;
use App\Http\Controllers\BackendV1\API\Traits\IssueTokenTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client;

class KioskAuthLogic extends AuthUseCase
{
    use IssueTokenTrait;

    private $client;

    public function __construct()
    {
        $this->client = Client::find(5);
    }

    public function handleLogin($request)
    {
        //is valid

        $kiosk = Kiosks::find($request->kioskId);

        if ($kiosk) {
            if ($kiosk->passcode == $request->passcode) {

                $OAuthLogin = $this->issueTokenWithResponse($request, 'client_credentials');
                if ($OAuthLogin['access_token'] != null) {

                    // Update kiosk activity
                    KioskActivity::updateOrCreate(['kioskId' => $kiosk->id], ['isLogined' => 1, 'lastLoginAt' => Carbon::now()]);

                    // Update token
                    $kiosk->update([
                        'apiToken' => $OAuthLogin['access_token']
                    ]);

                    /* Success Response*/
                    $response = array();
                    $response['isFailed'] = false;
                    $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                    $response['message'] = 'Login successful';

                    return response()->json($response, 200);

                } else {
                    $response = array();
                    $response['isFailed'] = true;
                    $response['code'] = ResponseCodes::$KIOSK_ERR_CODES['ACCESS_TOKEN_MISSING'];
                    $response['message'] = 'Unable to login , try again later';

                    return response()->json($response, 200);
                }

            } else {
                $response = array();
                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$KIOSK_ERR_CODES['PASSCODE_NOT_MATCH'];
                $response['message'] = 'Passcode does not match';

                return response()->json($response, 200);
            }
        } else {
            $response = array();
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$KIOSK_ERR_CODES['KIOSK_NOT_FOUND'];
            $response['message'] = 'Kiosk not found';

            return response()->json($response, 200);
        }

    }

    public function handleLogout($request)
    {
        $kiosk = Kiosks::find($request->kioskId);

        if ($kiosk) {
            if ($kiosk->passcode == $request->passcode) {
                if ($kiosk->update(['apiToken' => ''])) {
                    $response = array();
                    $response['isFailed'] = false;
                    $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                    $response['message'] = 'Logout successfully';

                    return response()->json($response, 200);
                } else {
                    $response = array();
                    $response['isFailed'] = true;
                    $response['code'] = ResponseCodes::$ERR_CODE['ELOQUENT_ERR'];
                    $response['message'] = 'Unable to logout . Try again later';

                    return response()->json($response, 200);
                }
            } else {
                $response = array();
                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$KIOSK_ERR_CODES['PASSCODE_NOT_MATCH'];
                $response['message'] = 'Passcode does not match';

                return response()->json($response, 200);
            }

        } else {
            $response = array();
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$KIOSK_ERR_CODES['KIOSK_NOT_FOUND'];
            $response['message'] = 'Kiosk not found';

            return response()->json($response, 200);
        }
    }

    public function handleActivation($request)
    {

        //is valid

        $kiosk = Kiosks::find($request->kioskId);

        if ($kiosk) {

            if ($kiosk->isActivated == 1) {

                $response = array();
                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$KIOSK_ERR_CODES['HAS_BEEN_ACTIVATED'];
                $response['message'] = 'Kiosk has already been activated';

                return response()->json($response, 200);
            }

            /* Activation Logic */
            if ($kiosk->activationCode == $request->activationCode) {

                // get api token by login first time
                $loginFirstTime = $this->issueTokenWithResponse($request, 'client_credentials');

                if ($loginFirstTime['access_token'] != null) {

                    // Update kiosk activity
                    KioskActivity::updateOrCreate(['kioskId' => $kiosk->id], ['isLogined' => 1, 'lastLoginAt' => Carbon::now()]);

                    if ($kiosk->update([
                        'passcode' => $request->passcode,
                        'apiToken' => $loginFirstTime['access_token'],
                        'isActivated' => 1
                    ])
                    ) {

                        /** Success Response **/
                        $response = array();
                        $response['isFailed'] = false;
                        $response['code'] = ResponseCodes::$SUCCEED_CODE['SUCCESS'];
                        $response['message'] = 'Kiosk has been successfully activated';
                        $response['kiosk'] = $kiosk;

                        return response()->json($response, 200);

                    } else {

                        $response = array();
                        $response['isFailed'] = true;
                        $response['code'] = ResponseCodes::$ERR_CODE['ELOQUENT_ERR'];
                        $response['message'] = 'Unable to activate Kiosk, try again later';

                        return response()->json($response, 200);

                    }

                } else {
                    $response = array();
                    $response['isFailed'] = true;
                    $response['code'] = ResponseCodes::$KIOSK_ERR_CODES['ACCESS_TOKEN_MISSING'];
                    $response['message'] = 'Unable to activate Kiosk, try again later';

                    return response()->json($response, 200);
                }
            } else {

                $response = array();
                $response['isFailed'] = true;
                $response['code'] = ResponseCodes::$KIOSK_ERR_CODES['ACTIVATION_CODE_MISMATCH'];
                $response['message'] = 'Activation Code does not match';

                return response()->json($response, 200);
            }
        } else {

            $response = array();
            $response['isFailed'] = true;
            $response['code'] = ResponseCodes::$KIOSK_ERR_CODES['KIOSK_NOT_FOUND'];
            $response['message'] = 'Kiosk not found';

            return response()->json($response, 200);


        }
    }
}
