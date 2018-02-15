<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 18/12/17
 * Time: 6:06 PM
 */

namespace App\Attendance\Console\Commands;


use App\Attendance\Events\UpdateKioskBatteryPower;
use App\Attendance\Jobs\CheckAttendanceSchedule;
use App\Attendance\Jobs\CheckAttendanceTimesheet;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class KioskBatteryChecker extends Command
{
    protected $signature = 'kiosk:battery';
    protected $description = 'Get kiosk battery power';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        event(new UpdateKioskBatteryPower());
    }
}