<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Salary;


use App\Employee\Models\MasterEmployee;
use App\Employee\Transformers\EmployeeBriefDetailTransfomer;
use App\Salary\Logics\InsertEmployeeBonusCutLogic;
use App\Salary\Logics\InsertEmployeeSalaryLogic;
use App\Salary\Logics\RemoveBonusCutLogic;
use App\Salary\Logics\UseBonusCutLogic;
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
        $employee = MasterEmployee::find($employeeId);

        if ($employee) {

            $employeeDivisionId = !is_null($employee->employment) ? $employee->employment->divisionId : '';

            $usedBonusCutInGeneral = GeneralBonusesCuts::all()->pluck('salaryBonusCutTypeId');

            $usedBonusCutByEmployee = EmployeeBonusesCuts::where('employeeId', $employeeId)->get()->pluck('salaryBonusCutTypeId');

            $salaryBonusCut = SalaryBonusCutType::where('isDeleted', '!=', 1)
                ->whereNotIn('id', $usedBonusCutByEmployee)
                ->whereNotIn('id', $usedBonusCutInGeneral)
                ->where(function ($query) use ($employeeDivisionId) {
                    $query->where('isRelatedToDivision',0)->orWhere(function($query)use($employeeDivisionId){
                        $query->where('isRelatedToDivision',1)->where('divisionId',$employeeDivisionId);// get where Division is related and same with this employee
                    });
                })
                ->get();

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            $response['bonuscut'] = fractal($salaryBonusCut, new SalaryBonusCutTransformer());

            return response()->json($response, 200);
        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to find employee data. An error might occurred';

            return response()->json($response, 200);
        }

    }

    /* @desc Save basic salary for employee */
    public function saveSalary(Request $request, $employeeId)
    {
        return InsertEmployeeSalaryLogic::save($request, $employeeId);
    }

    /* @desc Insert bonus cut to employee for the first time */
    public function useBonusCut(Request $request, $employeeId)
    {
        return UseBonusCutLogic::use ($request, $employeeId);
    }

    /* @desc Edit/Save inserted bonus cut for this employee */
    public function saveBonusCut(Request $request, $employeeId)
    {
        return InsertEmployeeBonusCutLogic::save($request, $employeeId);
    }

    /* @desc Remove inserted bonus cut for this employee */
    public function removeBonusCut(Request $request, $employeeId)
    {
        return RemoveBonusCutLogic::remove($request, $employeeId);
    }

}
