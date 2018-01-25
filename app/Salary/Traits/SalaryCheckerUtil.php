<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */
namespace App\Salary\Traits;


use App\Salary\Models\GenerateSalaryReportLogs;
use App\Salary\Models\PayrollSetting;
use App\Salary\Models\SalaryReport;
use App\Traits\GlobalUtils;
use Carbon\Carbon;


trait SalaryCheckerUtil
{

    /* @desc check if there is salary report that reached stage 2, and update it */
    public function checkStage2Confirm($generateSalaryReport, $salaryReports)
    {
        /* Payroll setting Max Day to Confirm Stage 1 */
        $maxConfirmationStage1 = PayrollSetting::where('name', 'max-days-confirmation-salary-stage-1')->first()['value'];

        $reachedStage2 = false;//default

        /* Check if today has reached stage2 confirmation*/
        if ($this->totalDays_($generateSalaryReport->generatedDate, Carbon::now()->format('d/m/Y')) >= $maxConfirmationStage1) {
            $reachedStage2 = true;
        }


        if ($reachedStage2) { // if today has already reached stage 2

            /* Run logic to check validation */
            foreach ($salaryReports as $salaryReport) {

                /* If status is still unconfirmed or waiting for confirmation */
                if ($salaryReport->confirmationStatusId == 2 || $salaryReport->confirmationStatusId == 3) {

                    $salaryReport->confirmationStatusId = 5; // update confirmation status => stage 2 confirmed
                    $salaryReport->isPostponed = 1; // update isPostponed => true
                    $salaryReport->save();

                }

            }
        }

        return true;
    }

    // used to prevent collision with GlobalUtils trait
    protected function totalDays_($fromDate, $toDate)
    {
        $fromDate = Carbon::createFromFormat('d/m/Y', $fromDate);
        $toDate = Carbon::createFromFormat('d/m/Y', $toDate);

        return $fromDate->diffInDays($toDate->addDay());
    }
}