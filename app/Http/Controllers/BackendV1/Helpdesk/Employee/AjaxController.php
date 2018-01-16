<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Employee;

use App\Account\Models\User;
use App\Account\Transformers\LoginDetailTransfomer;
use App\Account\Transformers\LoginEditTransfomer;
use App\Employee\Models\Employment;
use App\Employee\Models\FacePerson;
use App\Employee\Models\MasterEmployee;
use App\Employee\Models\Resignation;
use App\Employee\Transformers\EmployeeDetailTransfomer;
use App\Employee\Transformers\EmployeeEditTransfomer;
use App\Employee\Transformers\EmploymentEditTransfomer;
use App\Employee\Transformers\EmploymentTransfomer;
use App\Employee\Transformers\FaceAPIDetailTransfomer;
use App\Employee\Transformers\ResignationTransformer;
use App\Http\Controllers\BackendV1\Helpdesk\Traits\Configs;
use App\Http\Requests\Employee\EditMasterEmployeeRequest;
use App\Http\Requests\Employee\EmploymentRequest;
use App\Http\Requests\Employee\MasterEmployeeRequest;
use App\Traits\GlobalUtils;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AjaxController extends Controller
{

    use GlobalUtils;

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
                if($employee->idCardPhoto!='' && $employee->idCardPhoto!=null){
                    if(file_exists(base_path(Configs::$IMAGE_PATH['EMPLOYEE_PHOTO']). $employee->idCardPhoto)){
                        unlink(base_path(Configs::$IMAGE_PATH['EMPLOYEE_PHOTO']). $employee->idCardPhoto);
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
                if($employee->employeePhoto!=''&&$employee->employeePhoto!=null){
                    if(file_exists(base_path(Configs::$IMAGE_PATH['EMPLOYEE_PHOTO']).$employee->employeePhoto)){
                        unlink(base_path(Configs::$IMAGE_PATH['EMPLOYEE_PHOTO']).$employee->employeePhoto);
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
        $imagePath = base_path(Configs::$IMAGE_PATH['FACES_PHOTO'].$filename);
         unlink($imagePath); //delete image

        return response()->json('',200);

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
}
