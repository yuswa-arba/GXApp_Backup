<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 18/12/17
 * Time: 6:06 PM
 */

namespace App\Attendance\Console\Commands;


use App\Attendance\Jobs\CheckAttendanceSchedule;
use App\Attendance\Jobs\CheckAttendanceTimesheet;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AttendanceScheduleChecker extends Command
{
    protected $signature ='attendance:check-schedule';
    protected $description = 'Check attendance schedule';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        //php artisan queue:work --queue=checker
        CheckAttendanceSchedule::dispatch()->onConnection('database')->onQueue('checker');
    }
}