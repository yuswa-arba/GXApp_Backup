<?php

namespace App\Salary\Transformers;

use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;
use App\Salary\Models\GenerateSalaryReportLogs;
use App\Salary\Models\SalaryBonusCutType;
use App\Salary\Models\SalaryReport;
use App\Salary\Traits\SalaryUtils;
use App\Traits\GlobalUtils;
use League\Fractal\TransformerAbstract;

class PayrollGeneratedSalaryHistoryTransformer extends TransformerAbstract
{

    use GlobalUtils;
    use SalaryUtils;

    public function transform(GenerateSalaryReportLogs $reportLogs)
    {
        return [
            'id' => $reportLogs->id,
            'fromDate' => $reportLogs->fromDate,
            'toDate' => $reportLogs->toDate,
            'branchOfficeId' => $reportLogs->branchOfficeId,
            'branchOfficeName' => $this->getResultWithNullChecker1Connection($reportLogs, 'branchOffice', 'name'),
            'generatedDate' => $reportLogs->generatedDate,
            'generatedBy' => $reportLogs->generatedBy,
            'salaryReportIds' => $reportLogs->salaryReportIds,
            'totalWaitingConfimation' => $this->getTotalWaitingConfirmation($reportLogs->salaryReportIds),
            'totalConfirmed' => $this->getTotalConfirmed($reportLogs->salaryReportIds),
            'totalStage1Confirmed' => $this->getTotalStage1Confirmed($reportLogs->salaryReportIds),
            'totalStage2Confirmed' => $this->getTotalStage2Confirmed($reportLogs->salaryReportIds),
            'totalPostponed' => $this->getTotalPostponed($reportLogs->salaryReportIds),
            'totalSubmittedForPayroll' => $this->getTotalSubmittedForPayroll($reportLogs->salaryReportIds),
            'totalSalaryReport' => $this->getTotalSalaryReport($reportLogs->salaryReportIds),
            'isGeneratedForPayroll' => $reportLogs->isGeneratedForPayroll,
            'lastGeneratePayrollId' => $reportLogs->lastGeneratePayrollId

        ];
    }


    private function getTotalConfirmed($salaryReportIds)
    {
        return SalaryReport::whereIn('id', explode(' ', $salaryReportIds))->where('confirmationStatusId', 1)->count();
    }

    private function getTotalWaitingConfirmation($salaryReportIds)
    {
        return SalaryReport::whereIn('id', explode(' ', $salaryReportIds))->where('confirmationStatusId', 3)->count();
    }


    private function getTotalStage1Confirmed($salaryReportIds)
    {
        return SalaryReport::whereIn('id', explode(' ', $salaryReportIds))->where('confirmationStatusId', 4)->count();

    }

    private function getTotalStage2Confirmed($salaryReportIds)
    {
        return SalaryReport::whereIn('id', explode(' ', $salaryReportIds))->where('confirmationStatusId', 5)->count();

    }

    private function getTotalPostponed($salaryReportIds)
    {
        return SalaryReport::whereIn('id', explode(' ', $salaryReportIds))->where('isPostponed', 1)->count();
    }

    private function getTotalSubmittedForPayroll($salaryReportIds)
    {
        return SalaryReport::whereIn('id', explode(' ', $salaryReportIds))->where('isSubmittedForPayroll', 1)->count();
    }

    private function getTotalSalaryReport($salaryReportIds)
    {
        return count(explode(' ', $salaryReportIds));
    }
}
