<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\FaceAPI\Logics;


use App\Account\Events\UserNotified;
use App\Employee\Models\FacePerson;
use App\Http\Controllers\BackendV1\Helpdesk\Traits\Configs;
use App\Notification\Models\Notifications;
use App\Employee\Models\MasterEmployee;
use App\Traits\FirebaseUtils;
use App\Traits\GlobalConfig;
use App\Traits\GlobalConst;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;


class CreatePersonLogic extends CreatePersonUseCase
{

    use GlobalUtils;

    public function handle($request)
    {
        $guzzle = new Client();


        if (GlobalConst::$CONFIG['RUN_ON_PORT_80']) {
            $backendPath = URL::to('/') . GlobalConfig::$BACKEND_PATH_V1['HELPDESK'];
        } else {
            $backendPath = GlobalConst::$SERVER_ADDR['PRIVATE_PROD'] . GlobalConfig::$BACKEND_PATH_V1['HELPDESK'];
        }

        /* Send post request to Microsoft Face API */

        //request
        $createPersonRequest = $guzzle->request('POST', GlobalConfig::$MICROSOFT_FACE_API['BASE_URL'] .
            'persongroups/' . GlobalConfig::$MICROSOFT_FACE_API['PERSON_GROUP_ID'] . '/persons',
            [
                'headers' => ['Content-Type' => 'application/json', 'Ocp-Apim-Subscription-Key' => GlobalConfig::$MICROSOFT_FACE_API['SUB_KEY']],
                'json' => ['name' => $request['employeeFullName']]
            ]
        );

        //response
        $createPersonResponse = json_decode((string) $createPersonRequest->getBody(),true);

        if ($createPersonResponse['personId'] != null && $createPersonResponse['personId'] != '') {

            /* Save person id to database */
            $saveFacePerson = FacePerson::updateOrCreate(
                ['employeeId' => $request['employeeId'], 'personGroupId' => GlobalConfig::$MICROSOFT_FACE_API['PERSON_GROUP_ID']],
                ['personId' => $createPersonResponse['personId']]
            );

            /* Get Person Detail */
            if ($saveFacePerson) {

                $getPersonDetailRequest = $guzzle->request('GET', GlobalConfig::$MICROSOFT_FACE_API['BASE_URL'] . 'persongroups/' .
                    GlobalConfig::$MICROSOFT_FACE_API['PERSON_GROUP_ID'] . '/persons/' . $createPersonResponse['personId'],
                    ['headers' => ['Content-Type' => 'application/json', 'Ocp-Apim-Subscription-Key' => GlobalConfig::$MICROSOFT_FACE_API['SUB_KEY']]]
                );

                $getPersonDetailResponse = json_decode((string)$getPersonDetailRequest->getBody(),true);

                if ($getPersonDetailResponse['personId'] != null && $getPersonDetailResponse['personId'] != '') {


                    /* Add Person Face*/
                    $addPersonRequest = $guzzle->request('POST', GlobalConfig::$MICROSOFT_FACE_API['BASE_URL'] .
                        'persongroups/' . GlobalConfig::$MICROSOFT_FACE_API['PERSON_GROUP_ID'] . '/persons/' . $getPersonDetailResponse['personId'] .
                        '/persistedFaces',
                        [
                            'headers' => ['Content-Type' => 'application/json', 'Ocp-Apim-Subscription-Key' => GlobalConfig::$MICROSOFT_FACE_API['SUB_KEY']],
                            'json'=>['url' => 'https://static.highsnobiety.com/wp-content/uploads/2017/10/25100901/jaden-smith-album-release-date-syre-01-480x320.jpg']
                        ]
                    );

                    if($addPersonRequest->getStatusCode()==200){
                        /* Copy photo files*/

                        $addPersonResponse =  json_decode((string) $addPersonRequest->getBody(),true);

                        if($addPersonResponse['persistedFaceId']!='' && $addPersonResponse['persistedFaceId']!=null){
                            $copyfile = File::copy(
                                base_path(Configs::$IMAGE_PATH['EMPLOYEE_PHOTO']) . $request['filename'],//from
                                base_path(Configs::$IMAGE_PATH['FACES_PHOTO']) . $addPersonResponse['persistedFaceId'] . '.png'
                            );
                        }


                    }

                    /* Train Person Group*/
                    $trainPersonRequest = $guzzle->request('POST', GlobalConfig::$MICROSOFT_FACE_API['BASE_URL'] .
                        'persongroups/' . GlobalConfig::$MICROSOFT_FACE_API['PERSON_GROUP_ID'] . '/train',
                        ['headers' => ['Content-Type' => 'application/json', 'Ocp-Apim-Subscription-Key' => GlobalConfig::$MICROSOFT_FACE_API['SUB_KEY']]]
                    );
                }


            }

        }

    }
}