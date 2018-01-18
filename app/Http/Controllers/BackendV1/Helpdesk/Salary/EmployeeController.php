<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Salary;


use App\Employee\Models\MasterEmployee;
use App\Employee\Transformers\EmployeeBriefDetailTransfomer;
use App\Salary\Models\EmployeeBonusesCuts;
use App\Salary\Models\EmployeeSalary;
use App\Salary\Models\GeneralBonusesCuts;
use App\Salary\Models\SalaryBonusCutType;
use App\Salary\Transformers\EmployeeBonusCutTransformer;
use App\Salary\Transformers\EmployeeSalaryTransformer;
use App\Salary\Transformers\SalaryBonusCutTransformer;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class EmployeeController extends Controller
{

    use GlobalUtils;

    public function __construct()
    {
        $this->middleware(['permission:access salary']);
    }


    public function detail($employeeId)
    {
        if ($employeeId != null && $employeeId != '') {
            $employee = MasterEmployee::find($employeeId);

            if ($employee) {
                return response()->json([
                    'message' => 'Successful',
                    'employee' => fractal($employee, new EmployeeBriefDetailTransfomer()),
                    'salary' => fractal($employee->salary, new EmployeeSalaryTransformer()),
                    'bonusCut' => fractal($employee->bonusCut, new EmployeeBonusCutTransformer())
                ], 200);

            } else {
                return response()->json(['isFailed' => true, 'message' => 'Error occured! Unable to find employee data'], 200);
            }
        } else {
            return response()->json(['isFailed' => true, 'message' => 'Parameter ID is missing'], 200);
        }
    }

    public function availableBonusCutList($employeeId)
    {

        $usedBonusCutInGeneral = GeneralBonusesCuts::all()->pluck('salaryBonusCutTypeId');
        $usedBonusCutByEmployee = EmployeeBonusesCuts::where('employeeId', $employeeId)->get()->pluck('salaryBonusCutTypeId');

        $salaryBonusCut = SalaryBonusCutType::where('isDeleted', '!=', 1)
            ->whereNotIn('id', $usedBonusCutByEmployee)
            ->whereNotIn('id', $usedBonusCutInGeneral)
            ->get();

        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['bonuscut'] = fractal($salaryBonusCut, new SalaryBonusCutTransformer());

        return response()->json($response, 200);
    }

    public function saveSalary(Request $request, $employeeId)
    {
        $response = array();
        if ($employeeId != null && $employeeId != '') {

            // validate basic salary cannot be empty
            if ($request->basicSalary==null||$request->basicSalary=='') {
                $response['isFailed'] = true;
                $response['message'] = 'Salary cannot be empty';

                return response()->json($response, 200);
            }

            // is valid
            $insert = EmployeeSalary::updateOrCreate(
                ['employeeId' => $employeeId], // if this employee is found update it instead create a new one
                [
                    'basicSalary' => $request->basicSalary,
                    'insertedDate' => Carbon::now()->format('d/m/Y'),
                    'insertedBy' => !is_null(Auth::user()->employee) ? Auth::user()->employee->givenName : ''
                ]
            );

            /* Insert it to database */
            if ($insert) {

                $response = array();
                $response['isFailed'] = false;
                $response['message'] = 'Salary has been inserted successfully';
                $response['salary'] = fractal($insert,new EmployeeSalaryTransformer());

                return response()->json($response, 200);

            } else {
                $response['isFailed'] = true;
                $response['message'] = 'Unable to insert employee salary';
                return response()->json($response, 200);
            }


        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Parameter employee ID is missing';
            return response()->json($response, 200);
        }
    }

    public function saveBonusCut(Request $request, $employeeId)
    {
        $response = array();
        if ($employeeId != null && $employeeId != '') {

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Parameter employee ID is missing';
            return response()->json($response, 200);
        }
    }

}
