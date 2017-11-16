<?php

namespace App\Employee\Logics;

use App\Account\Models\User;
use App\Employee\Events\EmployeeCreated;
use App\Employee\Events\UserGenerated;
use App\Employee\Models\EmployeeDataVerification;
use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Traits\GlobalUtils;
use GuzzleHttp\Psr7\Request;

class Recruitment extends UseCase
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
            return response()->json($response, 500);
        }

    }

    private function submitToMasterEmployee($request)
    {

        /*Add unique ID param*/
        $request->request->add(['id' => $this->generateUUID()]);
        $request->request->add(['employeeNo' => str_random(6)]);

        $requestData = $request->all();

        /*Handle image uploads*/
        if ($request->hasFile('idCardPhoto') && $request->file('idCardPhoto')->isValid()) {
            $filename = $this->getImageName($request->idCardPhoto, $request->nickName);
            $request->idCardPhoto->move(base_path('public/images'), $filename);
            $requestData['idCardPhoto'] = $filename; //rename

        }

        /*Handle image uploads*/
        if ($request->hasFile('employeePhoto') && $request->file('employeePhoto')->isValid()) {
            $filename = $this->getImageName($request->employeePhoto, $request->nickName);
            $request->employeePhoto->move(base_path('public/images'), $filename);
            $requestData['employeePhoto'] = $filename; // rename
        }

        $employee = MasterEmployee::create($requestData);
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
     | Create Employment
     |--------------------------------------------------------------------------
     */

    public function handleEmployment($request)
    {
        $response = array();

        $employee = $this->saveEmploymentData($request);

        if ($employee) {

            $this->generateUserLogin($employee);

            /* Return success response */
            $response['isFailed'] = false;
            $response['message'] = 'Employment has been saved successfully';

            return response()->json($response, 200);

        } else {

            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'Unable to create employee, undefined employee';
            return response()->json($response, 500);
        }
    }

    private function saveEmploymentData($request)
    {
        $employment = Employment::create($request->all());

        return $employment->employee; // return employee data
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


}