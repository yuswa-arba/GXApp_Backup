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
use App\Salary\Models\SalaryCalculation;
use App\Salary\Models\SalaryReport;
use App\Traits\GlobalUtils;
use Carbon\Carbon;


class GetSalaryReportDetailsLogic extends GetReportDetailUseCase
{

    use GlobalUtils;

    public function handle($salaryReportLogId)
    {

        $generateSalaryReport = GenerateSalaryReportLogs::find($salaryReportLogId);

        if ($generateSalaryReport) {

            // Get employee
            $employeeIds = SalaryReport::whereIn('id', explode(' ', $generateSalaryReport->salaryReportIds))->get()->pluck('employeeId');
            $employees = MasterEmployee::whereIn('id', $employeeIds)->get();

            $salaryReportDetails = array();

            $h = 0;
            foreach ($employees as $employee) {

                /* Employee Salary Report arr*/
                $employeeData = array();
                $reportResult = array();

                /* Get employee data*/
                $employeeData['employeeId'] = $employee->id;
                $employeeData['employeeName'] = $employee->givenName . ' ' . $employee->surname;
                $employeeData['employeeNo'] = $employee->employeeNo;
                $employeeData['divisionId'] = $this->getResultWithNullChecker1Connection($employee, 'employment', 'divisionId');
                $employeeData['divisionName'] = $this->getResultWithNullChecker2Connection($employee, 'employment', 'division', 'name');

                /* Salary Reports */
                $salaryReports = SalaryReport::where('employeeId', $employee->id)->whereIn('id',explode(' ', $generateSalaryReport->salaryReportIds))->get()->sortByDesc('created_at');

                if (count($salaryReports) > 0) {

                    /* Get Salary Reports*/
                    $i = 0;
                    foreach ($salaryReports as $salaryReport) {

                        $reportResult[$i]['salaryReport']['id'] = $salaryReport->id;
                        $reportResult[$i]['salaryReport']['fromDate'] = $salaryReport->fromDate;
                        $reportResult[$i]['salaryReport']['toDate'] = $salaryReport->toDate;
                        $reportResult[$i]['salaryReport']['basicSalary'] = $salaryReport->basicSalary;
                        $reportResult[$i]['salaryReport']['totalSalaryBonus'] = $salaryReport->totalSalaryBonus;
                        $reportResult[$i]['salaryReport']['totalSalaryCut'] = $salaryReport->totalSalaryCut;
                        $reportResult[$i]['salaryReport']['salaryReceived'] = $salaryReport->salaryReceived;
                        $reportResult[$i]['salaryReport']['confirmationStatusId'] = $salaryReport->confirmationStatusId;
                        $reportResult[$i]['salaryReport']['confirmationStatusName'] = $this->getResultWithNullChecker1Connection($salaryReport, 'confirmationStatus', 'name');
                        $reportResult[$i]['salaryReport']['confirmationDate'] = $salaryReport->confirmationDate;
                        $reportResult[$i]['salaryReport']['isPostponed'] = $salaryReport->isPostponed;
                        $reportResult[$i]['salaryReport']['isSubmittedForPayroll'] = $salaryReport->isSubmittedForPayroll;
                        $reportResult[$i]['salaryReport']['generatePayrollId'] = $salaryReport->generatePayrollId;


                        /* Salary Calculations*/
                        $salaryCalculations = SalaryCalculation::where('salaryReportId', $salaryReport->id)
                            ->where('employeeId', $salaryReport->employeeId)
                            ->where('isDeleted', 0)// not deleted
                            ->get()
                            ->sortByDesc('created_at');

                        /* Get Salary Calculations details*/
                        $x = 0;
                        foreach ($salaryCalculations as $salaryCalculation) {

                            // Note: SBC = Salary Bonus/Cut
                            $reportResult[$i]['salaryCalculations'][$x]['SBCTypeId'] = $salaryCalculation->salaryBonusCutTypeId;
                            $reportResult[$i]['salaryCalculations'][$x]['SBCTypeName'] = $this->getResultWithNullChecker1Connection($salaryCalculation, 'salaryBonusCutType', 'name');
                            $reportResult[$i]['salaryCalculations'][$x]['SBCTypeAddOrSub'] = $this->getResultWithNullChecker1Connection($salaryCalculation, 'salaryBonusCutType', 'addOrSub');
                            $reportResult[$i]['salaryCalculations'][$x]['value'] = $salaryCalculation->value;
                            $reportResult[$i]['salaryCalculations'][$x]['notes'] = $salaryCalculation->notes;
                            $reportResult[$i]['salaryCalculations'][$x]['insertedDate'] = $salaryCalculation->insertedDate;
                            $reportResult[$i]['salaryCalculations'][$x]['insertedBy'] = $salaryCalculation->insertedBy;
                            $reportResult[$i]['salaryCalculations'][$x]['isEdited'] = $salaryCalculation->isEdited;
                            $reportResult[$i]['salaryCalculations'][$x]['editedDate'] = $salaryCalculation->editedDate;
                            $reportResult[$i]['salaryCalculations'][$x]['editedBy'] = $salaryCalculation->editedBy;
                            $reportResult[$i]['salaryCalculations'][$x]['isProcessed'] = $salaryCalculation->isProcessed;
                            $reportResult[$i]['salaryCalculations'][$x]['processedDate'] = $salaryCalculation->processedDate;

                            $x++;//increment
                        }
                        $i++;//increment
                    }

                }

                $salaryReportDetails['details'][$h]['employeeData'] = $employeeData;
                $salaryReportDetails['details'][$h]['reportResult'] = $reportResult;

                $h++;//incremnet
            }

            /* Insert to Salary Report*/
            $salaryReportDetails['summary']['totalEmployees'] = count($employees);
            $salaryReportDetails['summary']['branchOfficeId'] = $generateSalaryReport->branchOfficeId;
            $salaryReportDetails['summary']['branchOfficeName'] = $this->getResultWithNullChecker1Connection($generateSalaryReport,'branchOffice','name');
            $salaryReportDetails['summary']['fromDate'] = $generateSalaryReport->fromDate;
            $salaryReportDetails['summary']['toDate'] = $generateSalaryReport->toDate;


            $response['isFailed'] = false;
            $response['message'] = 'Success';
            $response['salaryReportDetails'] = $salaryReportDetails;
            return response()->json($response, 200);


        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to find generated salary report data';
            return response()->json($response, 200);
        }
    }
}