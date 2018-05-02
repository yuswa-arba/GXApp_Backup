<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Salary\Logics\Salary;


use App\Employee\Models\MasterEmployee;
use App\Salary\Models\PayrollSetting;
use App\Salary\Models\SalaryCalculation;
use App\Salary\Models\SalaryReport;
use App\Salary\Traits\SalaryUtils;
use App\Traits\GlobalUtils;


class GetSalaryReportHistoryLogic extends GetSalaryReportUseCase
{

    use GlobalUtils;
    use SalaryUtils;
    /*
     * @description create salaryReport
     * */
    public function handle($employeeID)
    {

        $response = array();
        $employeeData = array();
        $reportResult = array();


        /* Employee Data */
        $employee = MasterEmployee::find($employeeID);

        if ($employee) {

            /* Get employee data*/
            $employeeData['employeeId'] = $employeeID;
            $employeeData['employeeName'] = $employee->givenName . ' ' . $employee->surname;
            $employeeData['employeeNo'] = $employee->employeeNo;
            $employeeData['divisionId'] = $this->getResultWithNullChecker1Connection($employee,'employment','divisionId');
            $employeeData['divisionName'] = $this->getResultWithNullChecker2Connection($employee,'employment','division','name');

            /* Salary Reports */
            $salaryReports = SalaryReport::where('employeeId', $employeeID)->get()->sortByDesc('created_at');

            if (count($salaryReports) > 0) {

                /* Get Salary Reports*/
                $i = 0;
                foreach ($salaryReports as $salaryReport) {

                    $reportResult[$i]['id'] = $salaryReport->id;
                    $reportResult[$i]['fromDate'] = $salaryReport->fromDate;
                    $reportResult[$i]['toDate'] = $salaryReport->toDate;
                    $reportResult[$i]['basicSalary'] = $this->getEmployeeBasicSalary($salaryReport->basicSalary);
                    $reportResult[$i]['totalSalaryBonus'] = $this->formatRupiahCurrency($salaryReport->totalSalaryBonus);
                    $reportResult[$i]['totalSalaryCut'] = $this->formatRupiahCurrency($salaryReport->totalSalaryCut);
                    $reportResult[$i]['salaryReceived'] = $this->formatRupiahCurrency($salaryReport->salaryReceived);
                    $reportResult[$i]['confirmationStatusId'] = $salaryReport->confirmationStatusId;
                    $reportResult[$i]['confirmationStatusName'] = $this->getResultWithNullChecker1Connection($salaryReport, 'confirmationStatus', 'name');
                    $reportResult[$i]['confirmationDate'] = $salaryReport->confirmationDate;
                    $reportResult[$i]['isPostponed'] = $salaryReport->isPostponed;
                    $reportResult[$i]['isSubmittedForPayroll'] = $salaryReport->isSubmittedForPayroll;
                    $reportResult[$i]['generatePayrollId'] = $salaryReport->generatePayrollId;


                    /* Salary Calculations*/
                    $salaryCalculations = SalaryCalculation::where('salaryReportId', $salaryReport->id)
                        ->where('employeeId', $salaryReport->employeeId)
                        ->where('isDeleted',0) // not deleted
                        ->get()
                        ->sortByDesc('created_at');

                    /* Get Salary Calculations details*/
                    $x = 0;
                    foreach ($salaryCalculations as $salaryCalculation) {

                        // Note: SBC = Salary Bonus/Cut
                        $reportResult[$i]['salaryCalculations'][$x]['SBCTypeId'] = $salaryCalculation->salaryBonusCutTypeId;
                        $reportResult[$i]['salaryCalculations'][$x]['SBCTypeName'] = $this->getResultWithNullChecker1Connection($salaryCalculation, 'salaryBonusCutType', 'name');
                        $reportResult[$i]['salaryCalculations'][$x]['SBCTypeAddOrSub'] = $this->getResultWithNullChecker1Connection($salaryCalculation, 'salaryBonusCutType', 'addOrSub');
                        $reportResult[$i]['salaryCalculations'][$x]['value'] = $this->formatRupiahCurrency($salaryCalculation->value);
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


                $response['isFailed'] = false;
                $response['message'] = 'Success';
                $response['employeeData'] = $employeeData;
                $response['reportResult'] = $reportResult;

                return response()->json($response, 200);

            } else {
                $response['isFailed'] = true;
                $response['message'] = 'Salary reports data not found';
                return response()->json($response, 200);
            }

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Employee data not found';
            return response()->json($response, 200);
        }


    }

}