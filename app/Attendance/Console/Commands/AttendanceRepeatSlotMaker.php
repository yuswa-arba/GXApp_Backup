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
use App\Attendance\Jobs\RepeatGeneralSlot;
use App\Attendance\Jobs\RepeatSlotMaker;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AttendanceRepeatSlotMaker extends Command
{
    protected $signature ='attendance:repeat-slotmaker';
    protected $description = 'Repeat Slot Maker yearly';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        //php artisan queue:work --queue=checker
        RepeatGeneralSlot::dispatch()->onConnection('database')->onQueue('repeater');
        RepeatSlotMaker::dispatch()->onConnection('database')->onQueue('repeater');
    }
}