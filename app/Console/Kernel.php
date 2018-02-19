<?php

namespace App\Console;

use App\Attendance\Console\Commands\AttendanceRepeatSlotMaker;
use App\Attendance\Console\Commands\AttendanceScheduleChecker;
use App\Attendance\Console\Commands\AttendanceTimesheetChecker;
use App\Attendance\Console\Commands\KioskBatteryChecker;
use App\Attendance\Console\Commands\KioskLocalStorageChecker;
use App\Components\Console\Commands\SendHeartbeat;
use App\Salary\Console\Commands\SalaryConfirmationChecker;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\App;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Attendance\Console\Commands\AttendanceScheduleChecker::class,
        \App\Attendance\Console\Commands\AttendanceTimesheetChecker::class,
        \App\Attendance\Console\Commands\AttendanceRepeatSlotMaker::class,
        \App\Salary\Console\Commands\SalaryConfirmationChecker::class,
        \App\Components\Console\Commands\SendHeartbeat::class,
        \App\Attendance\Console\Commands\KioskBatteryChecker::class,
        \App\Attendance\Console\Commands\KioskLocalStorageChecker::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $this->scheduleInDayCommands($schedule);
        $this->scheduleDailyCommands($schedule);
//        $this->scheduleOnDayCommands($schedule);
        $this->scheduleYearlyCommands($schedule);
    }


    protected function scheduleInDayCommands(Schedule $schedule)
    {
        $schedule->command(AttendanceScheduleChecker::class)->everyMinute();
        $schedule->command(SendHeartbeat::class)->everyMinute();
        $schedule->command(AttendanceTimesheetChecker::class)->everyFiveMinutes();
        $schedule->command(KioskBatteryChecker::class)->hourly();
        $schedule->command(KioskLocalStorageChecker::class)->hourly();

    }

    protected function scheduleDailyCommands(Schedule $schedule)
    {
        $schedule->command(SalaryConfirmationChecker::class)->twiceDaily(8,12);
//        $schedule->command('service:generators:sitemap')->dailyAt('00:35');
//        $schedule->command('send:daily-emails')->dailyAt('00:00');
    }

    protected function scheduleOnDayCommands(Schedule $schedule)
    {
//        $schedule->command('client:mail:send-bonus-notifications')->weekdays()->at('10:00');
    }

    protected function scheduleYearlyCommands(Schedule $schedule)
    {
        /*Cron generator : https://crontab.guru */

        //At 00:00 on day-of-month 27 in December.
        $schedule->command(AttendanceRepeatSlotMaker::class)->cron('0 0 27 12 *');
    }


    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
