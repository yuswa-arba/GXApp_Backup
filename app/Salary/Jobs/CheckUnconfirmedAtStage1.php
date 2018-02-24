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
class CheckUnconfirmedAtStage1 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use GlobalUtils;

    public $tries = 10;

    public function __construct()
    {

    }

    /**
     * @desc check unconfirm salary report stage 1
     */
    public function handle()
    {
        /* Delays */
        $delayUnconfirmedStage1 = PayrollSetting::where('name', 'delay-unconfirmed-salary-stage-1')->first()['value'];

        /* Payroll setting Max Day to Confirm Stage 1 */
        $maxConfirmationStage1 = PayrollSetting::where('name', 'max-days-confirmation-salary-stage-1')->first()['value'];
        $maxConfirmationValidStage = PayrollSetting::where('name', 'max-days-confirmation-salary-valid-stage')->first()['value'];

        $nowTime = Carbon::createFromFormat('H:i', Carbon::now()->format('H:i'));
        $twelveAM = Carbon::createFromFormat('H:i', '12:00');

        $isInStage1 = false;//default

        // get only current year and last year
        $generateSalaryReports = GenerateSalaryReportLogs::orderBy('id', 'desc')->whereYear('created_at', Carbon::now()->year)->get();

        foreach ($generateSalaryReports as $generateSalaryReport) {

            /* Salary Reports Data */
            $salaryReports = SalaryReport::whereIn('id', explode(' ', $generateSalaryReport->salaryReportIds))->where(function ($query) {
                $query->where('confirmationStatusId', 2)->orWhere('confirmationStatusId', 3);
            })->get();


            /* Check if today is still in stage 1 confirmation*/
            if ($this->totalDays($generateSalaryReport->generatedDate, Carbon::now()->format('d/m/Y')) > $maxConfirmationValidStage &&
                $this->totalDays($generateSalaryReport->generatedDate, Carbon::now()->format('d/m/Y')) <= $maxConfirmationStage1
            ) {

                $isInStage1 = true;
            }

            if ($isInStage1) { // if today is in stage 1

                if ($salaryReports) {

                    /* Run logic to check validation */
                    foreach ($salaryReports as $salaryReport) {
                        if ($nowTime->lt($twelveAM)) {

                            //TODO: broadcast event to notify Users that they need to confirm salary TODAY before 12 AM to receive salary in stage 1
                        }
                    }
                }

            }

        }
    }

}