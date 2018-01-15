<?php

namespace App\Employee\Logics;

use App\Account\Models\User;
use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Employee\Models\Resignation;
use App\Employee\Transformers\ResignationTransformer;
use App\Http\Controllers\BackendV1\Helpdesk\Traits\Configs;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ResignationLogic extends ResignationUseCase
{

    use GlobalUtils;

    /*
     * Insert data to resignation table
     * Save resignation letter
     * Update hasResigned colum in MasterEmployee
     * Deactivate employee in user table
     * Update date of resignation in employment table
     * Send email (?)
     */
    public function handleProfessionalResignation($request)
    {

        $requestData = array();


        $requestData['employeeId'] = $request->employeeId;
        $requestData['submissionDate'] = $request->submissionDate;
        $requestData['effectiveDate'] = $request->effectiveDate;
        $requestData['professionalism'] = $request->professionalism;
        $requestData['reason'] = $request->reason;
        $requestData['submittedBy'] = !is_null(Auth::user()->employee) ? Auth::user()->employee->givenName : '';

        /*Handle image uploads*/
        if ($request->hasFile('resignationLetter') && $request->file('resignationLetter')->isValid()) {

            /*Remove previous image*/
            if ($request->resignationLetter != '' && $request->resignationLetter != null) {
                if (file_exists(base_path(Configs::$IMAGE_PATH['RESIGNATION_PHOTO']) . $request->resignationLetter)) {
                    unlink(base_path(Configs::$IMAGE_PATH['RESIGNATION_PHOTO']) . $request->resignationLetter);
                }
            }

            /*Save new image*/
            $employeeNo = MasterEmployee::find($request->employeeId)['employeeNo'];
            $filename = 'RL_' . $employeeNo . Carbon::now()->format('dmYHi') . $request->resignationLetter->extension();
            $request->resignationLetter->move(base_path(Configs::$IMAGE_PATH['RESIGNATION_PHOTO']), $filename);
            $requestData['resignationLetter'] = $filename; //rename

        }

        $resignation = Resignation::create($requestData);

        $response = array();


        if ($resignation) {

            $this->updateResignation($request->employeeId);
            $this->insertDateOfResignation($request->employeeId, $resignation->effectiveDate);
            $this->deactivateUser($request->employeeId);

            $response['isFailed'] = false;
            $response['message'] = 'Resignation has been created successfully';
            $response['resignation'] = fractal($resignation, new ResignationTransformer());
            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to create resignation';
            return response()->json($response, 200);
        }


    }

    /*
     * Insert data to resignation table
     * Update hasResigned colum in MasterEmployee
     * Deactivate employee in user table
     * Update date of resignation in employment table
     * Send email (?)
     */

    public function handleUnprofessionalResignation($request)
    {

        $requestData = array();


        $requestData['employeeId'] = $request->employeeId;
        $requestData['effectiveDate'] = $request->effectiveDate;
        $requestData['professionalism'] = $request->professionalism;
        $requestData['notes'] = $request->notes;
        $requestData['submittedBy'] = !is_null(Auth::user()->employee) ? Auth::user()->employee->givenName : '';


        $resignation = Resignation::create($requestData);

        $response = array();


        if ($resignation) {

            $this->updateResignation($request->employeeId);
            $this->insertDateOfResignation($request->employeeId, $resignation->effectiveDate);
            $this->deactivateUser($request->employeeId);

            $response['isFailed'] = false;
            $response['message'] = 'Resignation has been created successfully';
            $response['resignation'] = fractal($resignation, new ResignationTransformer());
            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to create resignation';
            return response()->json($response, 200);
        }

    }


    private function updateResignation($employeeId)
    {
        $employee = MasterEmployee::find($employeeId);

        if ($employee) {
            $employee->update(['hasResigned' => 1]);
        }


        return $this;
    }

    private function insertDateOfResignation($employeeId, $effectiveDate)
    {
        $employment = Employment::where('employeeId', $employeeId)->first();

        if ($employment) {
            $employment->update(['dateOfResignation' => $effectiveDate]);
        }

        return $this;
    }

    private function deactivateUser($employeeId)
    {
        $user = User::where('employeeId', $employeeId)->first();

        if ($user) {
            $user->update(['accessStatusId' => 2]);//blocked
        }

        return $this;
    }

}