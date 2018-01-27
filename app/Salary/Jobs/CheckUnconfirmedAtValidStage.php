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
class CheckUnconfirmedAtValidStage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use GlobalUtils;

    public $tries = 10;

    public function __construct()
    {

    }

    /**
     * @desc check unconfirm salary report valid stage
     */
    public function handle()
    {
        /* Payroll setting Max Day to Confirm Valid Stage */
        $maxConfirmationValidStage = PayrollSetting::where('name', 'max-days-confirmation-salary-valid-stage')->first()['value'];


        $nowTime = Carbon::createFromFormat('H:i', Carbon::now()->format('H:i'));
        $twelveAM = Carbon::createFromFormat('H:i', '12:00');

        $isValidStage = false;//default

        // get only current year and last year
        $generateSalaryReports = GenerateSalaryReportLogs::orderBy('id', 'desc')->whereYear('created_at', Carbon::now()->year)->get();


        foreach ($generateSalaryReports as $generateSalaryReport) {

            /* Salary Reports Data */
            $salaryReports = SalaryReport::whereIn('id', explode(' ', $generateSalaryReport->salaryReportIds))->where(function ($query) {
                $query->where('confirmationStatusId', 2)->where('confirmationStatusId', 3);
            })->get();


            /* Check if today has reached stage2 confirmation*/
            if ($this->totalDays($generateSalaryReport->generatedDate, Carbon::now()->format('d/m/Y')) <= $maxConfirmationValidStage ) {
                $isValidStage = true;
            }

            if ($isValidStage) { // if today is in valid stage

                $stage1Schedule = Carbon::createFromFormat('d/m/Y',$generateSalaryReport->generateDate)->addDays($maxConfirmationValidStage)->format('d/m/Y');

                if($salaryReports){
                    /* Run logic to check validation */
                    foreach ($salaryReports as $salaryReport) {

                        //TODO: broadcast event to notify users that they need to confirm to receive salary in time before $stage1Schedule at 12 AM

                    }
                }

            }
        }
    }

}