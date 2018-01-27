<?php
namespace App\Salary\Jobs;

use App\Attendance\Models\AttendanceSchedule;
use App\Attendance\Models\AttendanceTimesheet;
use App\Attendance\Models\Shifts;
use App\Attendance\Traits\AttendanceCheckerUtil;
use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use App\Http\Controllers\BackendV1\Helpdesk\Traits\Configs;
use App\Salary\Models\GenerateSalaryReportLogs;
use App\Salary\Models\PayrollSetting;
use App\Salary\Models\SalaryQueue;
use App\Salary\Models\SalaryReport;
use App\Salary\Traits\SalaryCheckerUtil;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 18/12/17
 * Time: 6:37 PM
 */
class CheckUnconfirmedAtStage2 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use GlobalUtils;

    public $tries = 10;

    public function __construct()
    {

    }

    /**
     * @desc check unconfirmed salary report at stage 2
     */
    public function handle()
    {
        /* Payroll setting Max Day to Confirm Stage 1 */
        $maxConfirmationStage1 = PayrollSetting::where('name', 'max-days-confirmation-salary-stage-1')->first()['value'];

        $reachedStage2 = false;//default

        $nowTime = Carbon::createFromFormat('H:i', Carbon::now()->format('H:i'));
        $twelveAM = Carbon::createFromFormat('H:i', '12:00');


        // get only current year and last year
        $generateSalaryReports = GenerateSalaryReportLogs::orderBy('id', 'desc')->whereYear('created_at', Carbon::now()->year)->get();

        foreach ($generateSalaryReports as $generateSalaryReport) {

            /* Salary Reports Data , only get unconfirmed / waiting for confirmation status*/
            $salaryReports = SalaryReport::whereIn('id', explode(' ', $generateSalaryReport->salaryReportIds))->where(function ($query) {
                $query->where('confirmationStatusId', 2)->where('confirmationStatusId', 3);
            })->get();


            /* Check if today has reached LAST DAY before stage2 confirmation*/
            if ($this->totalDays($generateSalaryReport->generatedDate, Carbon::now()->format('d/m/Y')) == $maxConfirmationStage1) {

                if ($nowTime->lt($twelveAM)) {
                    $lastDayBeforeStage2 = true;
                }

            }

            /* Check if today has reached stage2 confirmation*/
            if ($this->totalDays($generateSalaryReport->generatedDate, Carbon::now()->format('d/m/Y')) > $maxConfirmationStage1) {
                $reachedStage2 = true;
            }


            if ($reachedStage2) { // if today has already reached stage 2

                if ($salaryReports) {

                    /* Run logic to check validation */
                    foreach ($salaryReports as $salaryReport) {

                        if ($nowTime->gte($twelveAM)) {

                            $salaryReport->confirmationStatusId = 5; // update confirmation status => stage 2 confirmed
                            $salaryReport->isPostponed = 1; // update isPostponed => true
                            $salaryReport->save();

                            //TODO: notify USERS that salary will be received next month because they have reached stage 2

                            /* Insert postponed salary to salary queue */
                            SalaryQueue::create([
                                'employeeId' => $salaryReport->employeeId,
                                'salaryBonusCutTypeId' => 12, // postponed salary add
                                'value' => $salaryReport->salaryReceived,
                                'notes' => 'Postponed Salary (' . $salaryReport->fromDate . '-' . $salaryReport->toDate . ' period)',
                                'insertedDate' => Carbon::now()->format('d/m/Y'),
                                'insertedBy' => 'SYSTEM_CHECK'
                            ]);

                        } else {

                            //TODO: notify USERS that the last time to confirm stage 2 is TODAY before 12 AM
                        }

                    }

                }
            }
        }
    }
}