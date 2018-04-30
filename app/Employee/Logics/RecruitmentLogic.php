<?php

namespace App\Employee\Logics;

use App\Account\Models\User;
use App\Employee\Events\EmployeeCreated;
use App\Employee\Events\UserGenerated;
use App\Employee\Models\EmployeeDataVerification;
use App\Employee\Models\EmployeeMedicalRecords;
use App\Employee\Models\EmployeeSiblings;
use App\Employee\Models\Employment;
use App\Employee\Models\FingerspotUser;
use App\Employee\Models\MasterEmployee;
use App\FaceAPI\Logics\CreatePersonLogic;
use App\Fingerspot\Model\FingerspotDevice;
use App\Http\Controllers\BackendV1\Helpdesk\Traits\Configs;
use App\Traits\GlobalUtils;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;
use Karlmonson\Ping\Facades\Ping;

class RecruitmentLogic extends RecruitmentUseCase
{

    use GlobalUtils;

    /*
    |--------------------------------------------------------------------------
    | Create Master Employee
    |--------------------------------------------------------------------------
    */
    public function handleNewEmployeeForm($request)
    {

        $response = array();

        $employee = $this->submitToMasterEmployee($request);

        if ($employee) {

            $this->saveUnverifiedDataStatusState($employee);

            /* Return success response */
            $response['isFailed'] = false;
            $response['message'] = 'Employee has been created successfully';
            $response['employeeId'] = $employee->id;
            return response()->json($response, 200);

        } else {

            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'Unable to create employee, undefined employee ID';
            return response()->json($response, 200);
        }

    }

    private function submitToMasterEmployee($request)
    {
        /*Add unique ID param*/
        $request->request->add(['id' => $this->generateUUID()]);
//        $request->request->add(['employeeNo' => str_random(6)]);

        $requestData = $request->except([
            'lengthEmploymentTimeFormat',
            'siblingName',
            'siblingAddress',
            'siblingCity',
            'siblingPhoneNo',
            'siblingMaritalStatusId',
        ]); // remove from request

        /*Handle image uploads*/
        if ($request->hasFile('idCardPhoto') && $request->file('idCardPhoto')->isValid()) {

            /*Save new image*/
            $filename = $this->getImageName($request->idCardPhoto, $request->nickName);
            $requestData['idCardPhoto'] = $filename; //rename
            $request->idCardPhoto->move(base_path(Configs::$IMAGE_PATH['EMPLOYEE_PHOTO']), $filename);

        }

        /*Handle image uploads*/
        if ($request->hasFile('employeePhoto') && $request->file('employeePhoto')->isValid()) {

            /*Save new image*/
            $filename = $this->getImageName($request->employeePhoto, $request->nickName);
            $requestData['employeePhoto'] = $filename; // rename
            $request->employeePhoto->move(base_path(Configs::$IMAGE_PATH['EMPLOYEE_PHOTO']), $filename);


        }

        //create employee
        $employee = MasterEmployee::create($requestData);

        //save siblings
        if ($employee->numberOfSiblings > 0) {
            for ($i = 0; $i < $employee->numberOfSiblings; $i++) {

                EmployeeSiblings::create([
                    'employeeId' => $employee->id,
                    'name' => $request->siblingName[$i],
                    'address' => $request->siblingAddress[$i],
                    'city' => $request->siblingCity[$i]
                ]);

            }
        }

        /* Register face to Microsoft Face API to be used in attendance*/
        if (file_exists(base_path(Configs::$IMAGE_PATH['EMPLOYEE_PHOTO']) . $employee->employeePhoto)) {

            try {
                CreatePersonLogic::create(
                    [
                        'employeeId' => $employee->id,
                        'employeeFullName' => $employee->givenName . ' ' . $employee->surname,
                        'filename' => $employee->employeePhoto
                    ]
                );
            } catch (\Exception $exception) {
                Log::info($exception->getMessage());
            }

        }


        //return employee
        return $employee;
    }

    private function saveUnverifiedDataStatusState($employee)
    {
        EmployeeDataVerification::updateOrCreate(['employeeId' => $employee->id], ['employeeId' => $employee->id]);

        event(new EmployeeCreated($employee)); // trigger event to send email

        return $this;
    }


    /*
     |--------------------------------------------------------------------------
     | Create Medical Records
     |--------------------------------------------------------------------------
     */
    public function handleMedicalRecords($request)
    {
        $response = array();

        $medicalRecords = EmployeeMedicalRecords::create($request->all());

        if ($medicalRecords) {

            /* Return success response */
            $response['isFailed'] = false;
            $response['message'] = 'Medical Records has been saved successfully';
            return response()->json($response, 200);

        } else {

            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'Unable to create medical records';
            return response()->json($response, 200);
        }
    }


    /*
     |--------------------------------------------------------------------------
     | Create Employment
     |--------------------------------------------------------------------------
     */

    public function handleEmployment($request)
    {
        $response = array();

        $employment = $this->saveEmploymentData($request);

        if ($employment->employee) {

            $this->updateEmployeeNoBasedOnBranch($employment);
            $this->uploadEmployeeToFingerspot($employment->employee);
            $this->generateUserLogin($employment->employee);

            /* Return success response */
            $response['isFailed'] = false;
            $response['message'] = 'Employment has been saved successfully';

            return response()->json($response, 200);

        } else {

            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'Unable to create employee, undefined employee';
            return response()->json($response, 200);
        }
    }

    private function saveEmploymentData($request)
    {
        $employment = Employment::create($request->all());

        return $employment; // return employee data
    }

    private function updateEmployeeNoBasedOnBranch($employment)
    {
        $employee = MasterEmployee::find($employment->employee->id);

        //format : 17021201001 = ({date of entry : yymmdd}{branch code no}{order no})
        $employee->employeeNo = $this->convertDateDDMMYYYYtoYM($employment->dateOfEntry)
            . $employment->branchOffice->codeNo
            . $this->zeroPrefix(count(MasterEmployee::all()), 3);

        $employee->save();

        return $this;

    }

    private function generateUserLogin($employee)
    {
        $firstPassword = str_random(6);
        $user = User::create([
            'id' => $this->generateUUID(),
            'employeeId' => $employee->id,
            'email' => $employee->email,
            'password' => bcrypt($firstPassword)
        ]);

        event(new UserGenerated($user, $firstPassword)); // trigger event to send email

        return $this;
    }

    private function uploadEmployeeToFingerspot($employee)
    {
        try {

            if ($employee->employeeNo != null && $employee->employeeNo != '') {

                $create = FingerspotUser::updateOrCreate(
                    [
                        'employeeId' => $employee->id,
                    ],
                    [
                        'fingerspotUserId' => $employee->employeeNo
                    ]
                );

                if ($create) {
                    $device = FingerspotDevice::find(1);
                    if ($device) {

                        $health = Ping::check($device->server_ip); // check ping connection
                        if ($health == 200) {

                            $port = $device->server_port;
                            $url = $device->server_ip . "/user/set";

                            // 0  is default idx from fingerspot
                            // 39 is default alg_ver from fingerspot
                            $temp = '[{"pin":"' . $employee->employeeNo . '","idx":"' . '0' .
                                '","alg_ver":"' . '39' . '","template":"' . '' . '"}]';

                            $temp = str_replace("+", "%2B", $temp);

                            $param = array(
                                'sn' => $device->device_sn,
                                'PIN' => $employee->employeeNo,
                                'nama' => $employee->givenName . ' ' . $employee->surname,
                                'pwd' => 0,
                                'rfid' => 0,
                                'priv' => 0,
                            );

                            // add empty t
                            $param = http_build_query($param) . '&tmp=' . $temp;

                            $output = $this->sendRequest($url, $port, $param);

                            Log::info($output);
                        }

                    }

                }
            }


        } catch (\Exception $exception) {
            //do nothing
        }

        return $this;
    }

    private function sendRequest($url, $port, $parameter)
    {
        $curl = curl_init();
        set_time_limit(0);
        curl_setopt_array($curl, array(
                CURLOPT_PORT => $port,
                CURLOPT_URL => "http://" . $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $parameter,
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "content-type: application/x-www-form-urlencoded"
                ),
            )
        );
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            $response = ("Error #:" . $err);
        }

        return $response;
    }


}