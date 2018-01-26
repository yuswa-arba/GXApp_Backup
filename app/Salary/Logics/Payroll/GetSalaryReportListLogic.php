<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Salary\Logics\Payroll;

use App\Attendance\Models\AttendanceTimesheet;
use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\EmployeeSlotSchedule;
use App\Attendance\Models\Shifts;
use App\Components\Models\BranchOffice;
use App\Employee\Models\MasterEmployee;
use App\Http\Controllers\BackendV1\Helpdesk\Traits\Configs;
use App\Salary\Models\GeneralBonusesCuts;
use App\Salary\Models\GenerateSalaryReportLogs;
use App\Salary\Models\SalaryReport;
use App\Salary\Traits\SalaryCheckerUtil;
use App\Salary\Transformers\PayrollGeneratedSalaryHistoryTransformer;
use App\Traits\GlobalUtils;
use Carbon\Carbon;


class GetSalaryReportListLogic extends GetReportListUseCase
{

    use GlobalUtils;
    use SalaryCheckerUtil;


    public function handleDefault($request)
    {
        // get only current year
        $generateSalaryReports = GenerateSalaryReportLogs::orderBy('id', 'desc')->whereYear('created_at', Carbon::now()->year)->get();

        foreach ($generateSalaryReports as $generateSalaryReport) {
            /* Salary Reports Data */
            $salaryReports = SalaryReport::whereIn('id', explode(' ', $generateSalaryReport->salaryReportIds))->get();

            /* Check */
            $this->checkStage2Confirm($generateSalaryReport, $salaryReports);
        }

        $response = array();
        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['reports'] = fractal($generateSalaryReports, new PayrollGeneratedSalaryHistoryTransformer())->toArray()['data'];

        return response()->json($response, 200);
    }

    public function handleBySpecificBranchOffice($request)
    {
        $generateSalaryReports = GenerateSalaryReportLogs::orderBy('id', 'desc')
                ->whereYear('created_at', Carbon::now()->year)
                ->where('branchOfficeId',$request->branchOfficeId)->get();

        foreach ($generateSalaryReports as $generateSalaryReport) {
            /* Salary Reports Data */
            $salaryReports = SalaryReport::whereIn('id', explode(' ', $generateSalaryReport->salaryReportIds))->get();

            /* Check */
            $this->checkStage2Confirm($generateSalaryReport, $salaryReports);
        }

        $response = array();
        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['reports'] = fractal($generateSalaryReports, new PayrollGeneratedSalaryHistoryTransformer())->toArray()['data'];

        return response()->json($response, 200);
    }

    public function handleBySpecificYear($request)
    {
        // get only current year and last year
        $generateSalaryReports = GenerateSalaryReportLogs::orderBy('id', 'desc')
            ->whereYear('created_at', $request->year)->get();

        foreach ($generateSalaryReports as $generateSalaryReport) {
            /* Salary Reports Data */
            $salaryReports = SalaryReport::whereIn('id', explode(' ', $generateSalaryReport->salaryReportIds))->get();

            /* Check */
            $this->checkStage2Confirm($generateSalaryReport, $salaryReports);
        }

        $response = array();
        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['reports'] = fractal($generateSalaryReports, new PayrollGeneratedSalaryHistoryTransformer())->toArray()['data'];

        return response()->json($response, 200);
    }

    public function handleBySpecificYearAndBranchOffice($request)
    {
        $generateSalaryReports = GenerateSalaryReportLogs::orderBy('id', 'desc')
            ->whereYear('created_at', $request->year)
            ->where('branchOfficeId',$request->branchOfficeId)->get();

        foreach ($generateSalaryReports as $generateSalaryReport) {
            /* Salary Reports Data */
            $salaryReports = SalaryReport::whereIn('id', explode(' ', $generateSalaryReport->salaryReportIds))->get();

            /* Check */
            $this->checkStage2Confirm($generateSalaryReport, $salaryReports);
        }

        $response = array();
        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['reports'] = fractal($generateSalaryReports, new PayrollGeneratedSalaryHistoryTransformer())->toArray()['data'];

        return response()->json($response, 200);
    }
}