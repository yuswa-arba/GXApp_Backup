<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Employee;

use App\Account\Models\User;
use App\Account\Transformers\LoginDetailTransfomer;
use App\Account\Transformers\LoginEditTransfomer;
use App\Employee\Models\EmployeeMedicalRecords;
use App\Employee\Models\Employment;
use App\Employee\Models\FacePerson;
use App\Employee\Models\FingerspotUser;
use App\Employee\Models\MasterEmployee;
use App\Employee\Models\Resignation;
use App\Employee\Transformers\EmployeeDetailTransfomer;
use App\Employee\Transformers\EmployeeEditTransfomer;
use App\Employee\Transformers\EmployeeFingerspotTransformer;
use App\Employee\Transformers\EmployeeMedicalRecordDetailTransfomer;
use App\Employee\Transformers\EmployeeMedicalRecordEditTransfomer;
use App\Employee\Transformers\EmploymentEditTransfomer;
use App\Employee\Transformers\EmploymentTransfomer;
use App\Employee\Transformers\FaceAPIDetailTransfomer;
use App\Employee\Transformers\ResignationTransformer;
use App\Fingerspot\Model\FingerspotDevice;
use App\Http\Controllers\BackendV1\Helpdesk\Traits\Configs;
use App\Http\Requests\Employee\EditMasterEmployeeRequest;
use App\Http\Requests\Employee\EmploymentRequest;
use App\Http\Requests\Employee\MasterEmployeeRequest;
use App\Http\Requests\Employee\MedicalRecordsRequest;
use App\Traits\FingerspotUtils;
use App\Traits\FirebaseUtils;
use App\Traits\GlobalUtils;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Karlmonson\Ping\Facades\Ping;

class AjaxController extends Controller
{

    use GlobalUtils;
    use FingerspotUtils;
//    public function __construct()
//    {
//        $this->middleware(['role:admin','permission:create employee|edit employee|view employee']);
//    }

    public function masterEmployeeDetail($id)
    {
        if ($id != null && $id != '') {
            $employee = MasterEmployee::find($id);

            if ($employee) {
                return response()->json([
                    'message' => 'Successful',
                    'detail' => fractal($employee, new EmployeeDetailTransfomer())
                ], 200);

            } else {
                return response()->json(['message' => 'Error occured! Unable to find employee data'], 200);
            }
        } else {
            return response()->json(['message' => 'Parameter ID is missing'], 200);
        }
    }

    public function masterEmployeeEdit($id)
    {
        if ($id != null && $id != '') {

            $employee = MasterEmployee::find($id);

            if ($employee) {
                return response()->json([
                    'message' => 'Successful',
                    'detail' => fractal($employee, new EmployeeEditTransfomer())
                ], 200);

            } else {
                return response()->json(['message' => 'Error occured! Unable to find employee data'], 200);
            }
        } else {
            return response()->json(['message' => 'Parameter ID is missing'], 200);
        }
    }

    public function saveMasterEmployeeEdit(EditMasterEmployeeRequest $request)
    {
        $response = array();
        $employee = MasterEmployee::find($request->id);

        if ($employee) {

            $requestData = $request->all();

            /*Handle image uploads*/
            if ($request->hasFile('idCardPhoto') && $request->file('idCardPhoto')->isValid()) {

                /*Remove previous image*/
                if ($employee->idCardPhoto != '' && $employee->idCardPhoto != null) {
                    if (file_exists(base_path(Configs::$IMAGE_PATH['EMPLOYEE_PHOTO']) . $employee->idCardPhoto)) {
                        unlink(base_path(Configs::$IMAGE_PATH['EMPLOYEE_PHOTO']) . $employee->idCardPhoto);
                    }
                }

                /*Save new image*/
                $filename = $this->getImageName($request->idCardPhoto, $request->nickName);
                $request->idCardPhoto->move(base_path(Configs::$IMAGE_PATH['EMPLOYEE_PHOTO']), $filename);
                $requestData['idCardPhoto'] = $filename; //rename
            }

            /*Handle image uploads*/
            if ($request->hasFile('employeePhoto') && $request->file('employeePhoto')->isValid()) {

                /*Remove previous image*/
                if ($employee->employeePhoto != '' && $employee->employeePhoto != null) {
                    if (file_exists(base_path(Configs::$IMAGE_PATH['EMPLOYEE_PHOTO']) . $employee->employeePhoto)) {
                        unlink(base_path(Configs::$IMAGE_PATH['EMPLOYEE_PHOTO']) . $employee->employeePhoto);
                    }
                }

                /*Save new image*/
                $filename = $this->getImageName($request->employeePhoto, $request->nickName);
                $request->employeePhoto->move(base_path(Configs::$IMAGE_PATH['EMPLOYEE_PHOTO']), $filename);
                $requestData['employeePhoto'] = $filename; // rename
            }

            $employee->update($requestData);

            /* Return success response */
            $response['isFailed'] = false;
            $response['message'] = 'Master Employee has been saved successfully';

            return response()->json($response, 200);

        } else {

            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'Error occured! Unable to find employee data';

            return response()->json($response, 200);
        }
    }


    public function medicalRecordDetail($employeeId)
    {
        if ($employeeId != null && $employeeId != '') {

            $medicalRecord = EmployeeMedicalRecords::where('employeeId', $employeeId)->first();

            if ($medicalRecord) {
                return response()->json([
                    'message' => 'Successful',
                    'detail' => fractal($medicalRecord, new EmployeeMedicalRecordDetailTransfomer())
                ], 200);

            } else {
                return response()->json(['message' => 'Error occured! Unable to find employee medical record data'], 200);
            }
        } else {
            return response()->json(['message' => 'Parameter ID is missing'], 200);
        }
    }

    public function medicalRecordEdit($employeeId)
    {
        if ($employeeId != null && $employeeId != '') {

            $medicalRecord = EmployeeMedicalRecords::where('employeeId', $employeeId)->first();

            if ($medicalRecord) {
                return response()->json([
                    'message' => 'Successful',
                    'detail' => fractal($medicalRecord, new EmployeeMedicalRecordEditTransfomer())
                ], 200);

            } else {
                return response()->json(['message' => 'Error occured! Unable to find employee medical record data'], 200);
            }
        } else {
            return response()->json(['message' => 'Parameter ID is missing'], 200);
        }
    }

    public function saveMedicalRecordEdit(MedicalRecordsRequest $request)
    {
        $response = array();
        $medicalRecord = EmployeeMedicalRecords::where('employeeId', $request->employeeId)->first();

        if ($medicalRecord) { //if existed

            $update = $medicalRecord->update($request->all());

            if ($update) {

                /* Return success response */
                $response['isFailed'] = false;
                $response['message'] = 'Medical record has been saved successfully';

                return response()->json($response, 200);

            } else {

                /* Return error response */
                $response['isFailed'] = true;
                $response['message'] = 'Unable to update medical records data';

                return response()->json($response, 200);
            }

        } else { // non existed create a new one

            $create = $medicalRecord->create($request->all());

            if ($create) {

                /* Return success response */
                $response['isFailed'] = false;
                $response['message'] = 'Medical record has been saved successfully';

                return response()->json($response, 200);

            } else {

                /* Return error response */
                $response['isFailed'] = true;
                $response['message'] = 'Unable to create medical records data';

                return response()->json($response, 200);
            }
        }

    }


    public function employmentDetail($employeeId)
    {
        if ($employeeId != null && $employeeId != '') {

            $employment = Employment::where('employeeId', $employeeId)->first();

            if ($employment) {
                return response()->json([
                    'message' => 'Successful',
                    'detail' => fractal($employment, new EmploymentTransfomer())
                ], 200);

            } else {
                return response()->json(['message' => 'Error occured! Unable to find employee data'], 200);
            }
        } else {
            return response()->json(['message' => 'Parameter ID is missing'], 200);
        }
    }

    public function employmentEdit($employeeId)
    {
        if ($employeeId != null && $employeeId != '') {

            $employment = Employment::where('employeeId', $employeeId)->first();

            if ($employment) {
                return response()->json([
                    'message' => 'Successful',
                    'detail' => fractal($employment, new EmploymentEditTransfomer())
                ], 200);

            } else {
                return response()->json(['message' => 'Error occured! Unable to find employment data'], 200);
            }
        } else {
            return response()->json(['message' => 'Parameter ID is missing'], 200);
        }
    }

    public function saveEmploymentEdit(EmploymentRequest $request)
    {
        $response = array();
        $employment = Employment::where('employeeId', $request->employeeId)->first();

        if ($employment) {

            $employment->branchOfficeId = $request->branchOfficeId;
            $employment->dateOfEntry = $request->dateOfEntry;
            $employment->dateOfStart = $request->dateOfStart;
            $employment->divisionId = $request->divisionId;
            $employment->jobPositionId = $request->jobPositionId;
            $employment->recruitmentStatusId = $request->recruitmentStatusId;
            $employment->save();

            /* Return success response */
            $response['isFailed'] = false;
            $response['message'] = 'Employment has been saved successfully';

            return response()->json($response, 200);

        } else {

            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'Error occured! Unable to find employment data';

            return response()->json($response, 200);
        }


    }

    public function loginDetail($employeeId)
    {
        if ($employeeId != null && $employeeId != '') {

            $user = User::where('employeeId', $employeeId)->first();

            if ($user) {
                return response()->json([
                    'message' => 'Successful',
                    'detail' => fractal($user, new LoginDetailTransfomer())
                ], 200);

            } else {
                return response()->json(['message' => 'Error occured! Unable to find login data'], 200);
            }
        } else {
            return response()->json(['message' => 'Parameter ID is missing'], 200);
        }
    }

    public function loginEdit($employeeId)
    {
        if ($employeeId != null && $employeeId != '') {

            $user = User::where('employeeId', $employeeId)->first();

            if ($user) {
                return response()->json([
                    'message' => 'Successful',
                    'detail' => fractal($user, new LoginEditTransfomer())
                ], 200);

            } else {
                return response()->json(['message' => 'Error occured! Unable to find user data'], 200);
            }
        } else {
            return response()->json(['message' => 'Parameter ID is missing'], 200);
        }
    }

    public function saveLoginEdit(Request $request)
    {

        $request->validate([
            'employeeId' => 'required',
            'email' => 'required',
            'accessStatusId' => 'required',
            'allowAdminAccess' => 'required',
            'allowSuperAdminAccess' => 'required'
        ]);

        $response = array();
        $user = User::where('employeeId', $request->employeeId)->first();

        if ($user) {

            $user->accessStatusId = $request->accessStatusId;
            $user->allowAdminAccess = $request->allowAdminAccess;
            $user->allowSuperAdminAccess = $request->allowSuperAdminAccess;

            // if password is filled then change it
            if ($request->changePassword != '' && !empty($request->changePassword)) {
                $user->password = Hash::make($request->changePassword);
            }

            $user->save();

            /* Return success response */
            $response['isFailed'] = false;
            $response['message'] = 'Login detail has been saved successfully';

            return response()->json($response, 200);

        } else {
            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'Error occured! Unable to find user data';

            return response()->json($response, 200);
        }

    }

    public function faceAPIDetail($employeeId)
    {
        if ($employeeId != null && $employeeId != '') {

            $employee = MasterEmployee::where('id', $employeeId)->first();

            if ($employee) {
                return response()->json([
                    'message' => 'Successful',
                    'detail' => fractal($employee, new FaceAPIDetailTransfomer())
                ], 200);

            } else {
                return response()->json(['message' => 'Error occured! Unable to find user data'], 200);
            }
        } else {
            return response()->json(['message' => 'Parameter ID is missing'], 200);
        }
    }

    public function saveFaceApiPerson(Request $request)
    {
        $request->validate([
            'employeeId' => 'required',
            'personId' => 'required',
            'personGroupId' => 'required'
        ]);

        $response = array();

        $saveFacePerson = FacePerson::updateOrCreate(
            ['employeeId' => $request->employeeId, 'personGroupId' => $request->personGroupId],
            ['personId' => $request->personId,]
        );

        if ($saveFacePerson) {
            $response['isFailed'] = false;
            $response['message'] = 'Save to face person table success';
        } else {
            $response['isFailed'] = true;
            $response['message'] = 'An error occured.Unable to save face person';
        }

        return response()->json($response, 200);
    }

    public function saveFacePhoto(Request $request)
    {

        $request->validate(['facePhoto' => 'required', 'persistedFaceId' => 'required']);

        //is valid

        $response = array();

        if ($request->hasFile('facePhoto') && $request->file('facePhoto')->isValid()) {
//            $filename = $request->persistedFaceId . '.' . $request->facePhoto->extension();
            $filename = $request->persistedFaceId . '.png'; //use png

            $request->facePhoto->move(base_path(Configs::$IMAGE_PATH['FACES_PHOTO']), $filename);

            $response['isFailed'] = false;
            $response['message'] = 'Save face photo success';

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'File not found';
        }

        return response()->json($response, 200);
    }

    public function deleteFacePhoto($persistedFaceId)
    {
        $filename = $persistedFaceId . '.png'; //use png
        $imagePath = base_path(Configs::$IMAGE_PATH['FACES_PHOTO'] . $filename);
        unlink($imagePath); //delete image

        return response()->json('', 200);

    }

    public function resignationDetail($employeeId)
    {
        if ($employeeId != null && $employeeId != '') {

            $employment = Resignation::where('employeeId', $employeeId)->first();

            if ($employment) {
                return response()->json([
                    'message' => 'Successful',
                    'detail' => fractal($employment, new ResignationTransformer())
                ], 200);

            } else {
                return response()->json(['message' => 'Error occured! Unable to find employee data'], 200);
            }
        } else {
            return response()->json(['message' => 'Parameter ID is missing'], 200);
        }
    }

    public function fingerspotDetail($employeeId)
    {
        if ($employeeId != null && $employeeId != '') {

            $user = FingerspotUser::where('employeeId', $employeeId)->first();

            if ($user) {
                return response()->json([
                    'message' => 'Successful',
                    'detail' => fractal($user, new EmployeeFingerspotTransformer())
                ], 200);

            } else {
                return response()->json(['message' => 'Error occured! Unable to find fingerspot data'], 200);
            }
        } else {
            return response()->json(['message' => 'Parameter ID is missing'], 200);
        }
    }

    public function uploadFingerspotUser($employeeId)
    {
        $employee = MasterEmployee::find($employeeId);

        if ($employee) {

            $insert = FingerspotUser::updateOrCreate(
                [
                    'employeeId' => $employee->id
                ],
                [
                    'fingerspotUserId'=>$employee->employeeNo
                ]
            );

            if($insert){

                //upload to fingerspot
                $device = FingerspotDevice::find(1);
                if ($device) {

                    $health = Ping::check($device->server_ip); // check ping connection
//                    if ($health == 200) {

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

                        $output = $this->sendRequestToFingerspotDevice($url, $port, $param);

                        Log::info($output);
                    }

//                }




                $response['isFailed'] = false;
                $response['message'] = 'Success';
                $response['detail']=  fractal($insert, new EmployeeFingerspotTransformer());
                return response()->json($response,200);
            } else{
                $response['isFailed'] = true;
                $response['message'] = 'Unable to upload';
                return response()->json($response,200);
            }

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to find employee data';
            return response()->json($response, 200);
        }
    }

    public function deleteFingerspotUser($employeeId)
    {
        $employee = MasterEmployee::find($employeeId);
        if ($employee) {

            $delete = FingerspotUser::where('employeeId',$employee->id)->delete();

            if($delete){
                $response['isFailed'] = false;
                $response['message'] = 'Success';
                return response()->json($response,200);
            } else{
                $response['isFailed'] = true;
                $response['message'] = 'Unable to delete';
                return response()->json($response,200);
            }
        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to find employee data';
            return response()->json($response, 200);
        }
    }
}
