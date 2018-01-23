<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Salary\Logics\Salary;

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
use Illuminate\Support\Facades\Auth;


class GenerateSalaryLogic extends GenerateUseCase
{

    use GlobalUtils;

    /*
     * @description create salaryReport
     * */
    public function handle($request)
    {

        $response = array();

        $reports =$this->handleAttempt($request);
        $reports =  json_decode($reports,true);

        if (!$reports['isFailed']) { //success

            // All Salary Reports
            $salaryReports = $reports['salaryReport'];

            // Summary Salary Report
            $summarySalaryReport = $salaryReports['summary'];

            // Employee Salary Reports
            $employeesSalaryReports = $salaryReports['employeesSalaryReport'];

            /* inserted salary report id for logs*/
            $insertedSalaryReportIds = array();

            /* Loop through employee reports and insert it to DB */
            if(is_array($employeesSalaryReports)||is_object($employeesSalaryReports)){
                foreach ($employeesSalaryReports as $esr) {

                    if (isset($esr['salarySummary'])) {

                        $salary = $esr['salarySummary'];

                        $insert = SalaryReport::updateOrCreate(
                            [
                                'employeeId' => $esr['employeeId'],
                                'fromDate' => $summarySalaryReport['fromDate'],
                                'toDate' => $summarySalaryReport['toDate']
                            ],
                            [
                                'basicSalary' => $salary['basicSalary'],
                                'totalSalaryBonus' => $salary['totalBonus'],
                                'totalSalaryCut' => $salary['totalCut'],
                                'salaryReceived' => $salary['salaryReceived']
                            ]
                        );

                        /* If its inserted to DB then save the salary calculation & save logs*/
                        if ($insert) {

                            // insert id to array to save logs later
                            array_push($insertedSalaryReportIds, $insert->id);

                            // insert general bonus/cuts to salary calculation
                            if (isset($esr['generalBonusCut'])) {

                                $employeeBonusCuts = $esr['generalBonusCut'];

                                foreach ($employeeBonusCuts as $generalBonusCut) {

                                    SalaryCalculation::updateOrcreate(
                                        [
                                            'salaryReportId' => $insert->id,
                                            'employeeId' => $esr['employeeId'],
                                            'salaryBonusCutTypeId' => $generalBonusCut['salaryBonusCutTypeId'],
                                            'fromDate' => $summarySalaryReport['fromDate'],
                                            'toDate' => $summarySalaryReport['toDate'],
                                            'isDeleted' => 0,
                                            'isEdited' => 0,
                                            'isProcessed' => 0
                                        ],
                                        [
                                            'value' => $generalBonusCut['value'],
                                            'insertedDate' => Carbon::now()->format('d/m/Y'),
                                            'insertedBy' => $this->getResultWithNullChecker1Connection(Auth::user(), 'employee', 'givenName'),
                                        ]
                                    );
                                }
                            }

                            //insert employee bonus/cuts to salary calculation
                            if (isset($esr['employeeBonusCuts'])) {

                                $employeeBonusCuts = $esr['employeeBonusCut'];

                                foreach ($employeeBonusCuts as $employeeBonusCut) {

                                    SalaryCalculation::updateOrcreate(
                                        [
                                            'salaryReportId' => $insert->id,
                                            'employeeId' => $esr['employeeId'],
                                            'salaryBonusCutTypeId' => $employeeBonusCut['salaryBonusCutTypeId'],
                                            'fromDate' => $summarySalaryReport['fromDate'],
                                            'toDate' => $summarySalaryReport['toDate'],
                                            'isDeleted' => 0,
                                            'isEdited' => 0,
                                            'isProcessed' => 0
                                        ],
                                        [
                                            'value' => $employeeBonusCut['value'],
                                            'insertedDate' => Carbon::now()->format('d/m/Y'),
                                            'insertedBy' => $this->getResultWithNullChecker1Connection(Auth::user(), 'employee', 'givenName'),
                                        ]
                                    );
                                }
                            }
                        }
                    }

                    //TODO Trigger event to alert Employee in personal app using Push Notifications

                }
                /* Save Logs */
                GenerateSalaryReportLogs::create(
                    [
                        'fromDate'=>$summarySalaryReport['fromDate'],
                        'toDate'=>$summarySalaryReport['toDate'],
                        'branchOfficeId'=>$summarySalaryReport['branchOfficeId'],
                        'generatedDate'=>Carbon::now()->format('d/m/Y'),
                        'generatedBy'=>$this->getResultWithNullChecker1Connection(Auth::user(), 'employee', 'givenName'),
                        'salaryReportIds'=>implode(' ',$insertedSalaryReportIds)
                    ]
                );

                /* Return success response */
                $response['isFailed'] = false;
                $response['message'] = 'Salary reports has been generated successfully';
                return response()->json($response, 200);

            } else { //failed
                $response['isFailed'] = true;
                $response['message'] = 'An error occured! Invalid argument';
                return response()->json($response, 200);

            }

        } else { //failed
            $response['isFailed'] = true;
            $response['message'] = $reports['message'];
            return response()->json($response, 200);
        }


    }

    /*
     * @desc return data before generate
     * @return mixed
     * */
    public function handleAttempt($request)
    {
        /* Date range array*/
        $dateRange = $this->generateDateRange($request->fromDate, $request->toDate, 'd/m/Y');

        /* Get employee that is still active and match specific branch office Id*/
        $employees = MasterEmployee::where('hasResigned', 0)->whereHas('employment', function ($query) use ($request) {
            $query->where('branchOfficeId', $request->branchOfficeId);
        })->get();

        /* GENERAL bonus cuts*/
        $generalBonusCuts = GeneralBonusesCuts::all();

        /* Salary report array*/
        $salaryReport = array();

        /* Employee Salary Report arr*/
        $employeeSalaryReport = array();


        $i = 0;
        foreach ($employees as $employee) {

            $employeeId = $employee->id;

            $employeeSalaryReport[$i]['employeeId'] = $employeeId; // employee ID
            $employeeSalaryReport[$i]['employeeNo'] = $employee->employeeNo; // employee no
            $employeeSalaryReport[$i]['employeeName'] = $employee->givenName . ' ' . $employee->surname; // employee name
            $employeeSalaryReport[$i]['divisionName'] = $this->getResultWithNullChecker2Connection($employee, 'employment', 'division', 'name');

            $totalDayAbsence = 0; //absence
            $totalMinLate = 0; // min late
            $totalMinEarlyOut = 0; // min early out
            $totalBonus = 0; //total bonus
            $totalCut = 0;// total cut

            foreach ($dateRange as $date) {

                /* Filter timesheet remove Holiday & Leave
                 * 1. Get slot ID if assigned, else use 1 (general)
                 * 2. Check if date exist in day off schedule table based on slotId, if it does, don't include it in array
                 * 3. Check date in employee leave schedule, if exist, don't include it in array //TODO : employee leave schedule still not working
                 *
                */

                $slotId = 1; // default

                // if slot Id found, update slotId variable
                if ($this->getEmployeeSlotId($employeeId)) {
                    $slotId = $this->getEmployeeSlotId($employeeId);
                }

                // if its not day off and not employee leave schedule then insert date to array
                if (!$this->isDayOffForThisSlot($slotId, $date) && !$this->employeeLeaveSchedule($employeeId, $date)) {

                    $timesheetId = AttendanceTimesheet::where('employeeId', $employeeId)
                        ->where('clockInDate', $date)
                        ->whereNotNull('clockOutDate')
                        ->first()['id'];

                    if (!$timesheetId) {
                        $totalDayAbsence++; // add absence
                    } else {
                        $totalMinLate = $totalMinLate + $this->countMinutesCheckInLate($timesheetId);
                        $totalMinEarlyOut = $totalMinEarlyOut + $this->countMinutesCheckOutEarly($timesheetId);
                    }

                }

            }

            /* Set values */
            $employeeSalaryReport[$i]['timesheetSummary']['totalDayAbsence'] = $totalDayAbsence;
            $employeeSalaryReport[$i]['timesheetSummary']['totalMinLate'] = $totalMinLate;
            $employeeSalaryReport[$i]['timesheetSummary']['totalMinEarlyOut'] = $totalMinEarlyOut;


            /* get employee salary*/
            $employeeSalary = $this->getResultWithNullChecker1Connection($employee, 'salary', 'basicSalary');


            /* start calculation */
            if ($employeeSalary) {

                $x = 0; // general bonus cut array
                $y = 0; // employee bonus cut array

                /* Calculate GENERAL bonus cuts*/
                foreach ($generalBonusCuts as $generalBonusCut) {

                    $calculation = 0;//default calculation

                    if ($generalBonusCut->isUsingFormula) {

                        /* FORMULA calculation */

                        $formula = $generalBonusCut->formula; // default

                        $formula = str_replace(Configs::$SALARY_FORMULA_OPEARTOR['SALARY'], $employeeSalary, $formula); // salary
                        $formula = str_replace(Configs::$SALARY_FORMULA_OPEARTOR['MIN_LATE_IN'], $totalMinLate, $formula); // min late in
                        $formula = str_replace(Configs::$SALARY_FORMULA_OPEARTOR['MIN_EARLY_OUT'], $totalMinEarlyOut, $formula); // min early out
                        $formula = str_replace(Configs::$SALARY_FORMULA_OPEARTOR['DAY_ABSENCE'], $totalDayAbsence, $formula); // day absence

                        $calculation = eval('return ' . $formula . ';');

                    } else {
                        $calculation = $generalBonusCut->value; // not using formula so get value instead
                    }

                    $employeeSalaryReport[$i]['generalBonusCut'][$x]['salaryBonusCutTypeId'] = $this->getResultWithNullChecker1Connection($generalBonusCut, 'salaryBonusCutType', 'id');
                    $employeeSalaryReport[$i]['generalBonusCut'][$x]['name'] = $this->getResultWithNullChecker1Connection($generalBonusCut, 'salaryBonusCutType', 'name');
                    $employeeSalaryReport[$i]['generalBonusCut'][$x]['addOrSub'] = $this->getResultWithNullChecker1Connection($generalBonusCut, 'salaryBonusCutType', 'addOrSub');
                    $employeeSalaryReport[$i]['generalBonusCut'][$x]['value'] = $calculation;


                    // total bonus & cuts
                    if ($this->getResultWithNullChecker1Connection($generalBonusCut, 'salaryBonusCutType', 'addOrSub') == 'add') {
                        $totalBonus = $totalBonus + $calculation;
                    } elseif ($this->getResultWithNullChecker1Connection($generalBonusCut, 'salaryBonusCutType', 'addOrSub') == 'sub') {
                        $totalCut = $totalCut + $calculation;
                    }


                    $x++; //increment array
                }

                /* Calculate EMPLOYEE bonus cuts*/
                foreach ($employee->bonusCut as $bonusCut) {

                    $calculation = 0; //default calculation

                    /* check if bonus cut is active*/
                    if ($bonusCut->isActive) {

                        if ($bonusCut->isUsingFormula) {

                            /* FORMULA calculation */

                            $formula = $bonusCut->formula; // default

                            $formula = str_replace(Configs::$SALARY_FORMULA_OPEARTOR['SALARY'], $employeeSalary, $formula); // salary
                            $formula = str_replace(Configs::$SALARY_FORMULA_OPEARTOR['MIN_LATE_IN'], $totalMinLate, $formula); // min late in
                            $formula = str_replace(Configs::$SALARY_FORMULA_OPEARTOR['MIN_EARLY_OUT'], $totalMinEarlyOut, $formula); // min early out
                            $formula = str_replace(Configs::$SALARY_FORMULA_OPEARTOR['MIN_LATE_OUT'], $totalMinEarlyOut, $formula); // min late out
                            $formula = str_replace(Configs::$SALARY_FORMULA_OPEARTOR['DAY_ABSENCE'], $totalDayAbsence, $formula); // day absence

                            $calculation = eval('return ' . $formula . ';');

                        } else {
                            $calculation = $bonusCut->value;
                        }

                    }

                    $employeeSalaryReport[$i]['employeeBonusCut'][$y]['id'] = $this->getResultWithNullChecker1Connection($bonusCut, 'salaryBonusCutType', 'id');
                    $employeeSalaryReport[$i]['employeeBonusCut'][$y]['name'] = $this->getResultWithNullChecker1Connection($bonusCut, 'salaryBonusCutType', 'name');
                    $employeeSalaryReport[$i]['employeeBonusCut'][$y]['addOrSub'] = $this->getResultWithNullChecker1Connection($bonusCut, 'salaryBonusCutType', 'addOrSub');
                    $employeeSalaryReport[$i]['employeeBonusCut'][$y]['value'] = $calculation;


                    // total bonus & cuts
                    if ($this->getResultWithNullChecker1Connection($bonusCut, 'salaryBonusCutType', 'addOrSub') == 'add') {
                        $totalBonus = $totalBonus + $calculation;
                    } elseif ($this->getResultWithNullChecker1Connection($bonusCut, 'salaryBonusCutType', 'addOrSub') == 'sub') {
                        $totalCut = $totalCut + $calculation;
                    }


                    $y++; // increment array

                }

            }

            $employeeSalaryReport[$i]['salarySummary']['basicSalary'] = (float)$employeeSalary;
            $employeeSalaryReport[$i]['salarySummary']['totalBonus'] = $totalBonus;
            $employeeSalaryReport[$i]['salarySummary']['totalCut'] = $totalCut;
            $employeeSalaryReport[$i]['salarySummary']['salaryReceived'] = (float)$employeeSalary + (float)$totalBonus - (float)$totalCut;

            /* Incrementing array */
            $i++;

        }


        /* Insert to Salary Report*/
        $salaryReport['summary']['totalEmployees'] = count($employees);
        $salaryReport['summary']['branchOfficeId'] = $request->branchOfficeId;
        $salaryReport['summary']['branchOfficeName'] = BranchOffice::find($request->branchOfficeId)->name;
        $salaryReport['summary']['fromDate'] = $request->fromDate;
        $salaryReport['summary']['toDate'] = $request->toDate;
        $salaryReport['employeesSalaryReport'] = $employeeSalaryReport;


        /* RETURN RESPONSE */
        $response = array();
        $response['isFailed'] = false;
        $response['message'] = 'Success';
        $response['salaryReport'] = $salaryReport;

//        return response()->json($response, 200);

        return json_encode($response);
    }


    private function getEmployeeSlotId($employeeId)
    {
        $employeeSlotSchedule = EmployeeSlotSchedule::where('employeeId', $employeeId)->first();

        // if employee assigned to slot return slotId
        if ($employeeSlotSchedule) {
            return $employeeSlotSchedule->slotId;
        }

        // else return null
        return null;

    }

    private function isDayOffForThisSlot($slotId, $date)
    {

        $checkDayOffSchedule = DayOffSchedule::where('slotId', $slotId)->where('date', $date)->count();

        // if day off schedule found return TRUE
        if ($checkDayOffSchedule > 0) {
            return true;
        }

        // else return FALSE
        return false;

    }

    private function employeeLeaveSchedule($employeeId, $date)
    {
        //TODO: CHECK IF THIS SPECIFIC DATE IS EMPLOYEE LEAVE SCHEDULE
        return false;
    }

    private function countMinutesCheckInLate($timesheetId)
    {
        $timesheet = AttendanceTimesheet::find($timesheetId);

        if ($timesheet->clockInDate != '' && $timesheet->clockInTime != '') {
            $clockInTime = Carbon::createFromFormat('d/m/Y H:i', $timesheet->clockInDate . ' ' . $timesheet->clockInTime);
            $shift = Shifts::find($timesheet->shiftId);
            $shiftWorkStartAt = Carbon::createFromFormat('d/m/Y H:i', $timesheet->clockInDate . ' ' . $shift->workStartAt);

            // if its late then return minutes late
            if ($clockInTime->gt($shiftWorkStartAt)) {
                return $clockInTime->diffInMinutes($shiftWorkStartAt);
            }
        }


        return 0;
    }

    private function countMinutesCheckOutEarly($timesheetId)
    {

        $timesheet = AttendanceTimesheet::find($timesheetId);

        if ($timesheet->clockOutDate != '' && $timesheet->clockOutTime != '') {
            $clockOutTime = Carbon::createFromFormat('d/m/Y H:i', $timesheet->clockOutDate . ' ' . $timesheet->clockOutTime);
            $shift = Shifts::find($timesheet->shiftId);
            $shiftWorkEndAt = Carbon::createFromFormat('d/m/Y H:i', $timesheet->clockOutDate . ' ' . $shift->workEndAt);

            // if its early then return minutes early
            if ($clockOutTime->lt($shiftWorkEndAt)) {
                return $clockOutTime->diffInMinutes($shiftWorkEndAt);
            }
        }

        return 0;
    }


}