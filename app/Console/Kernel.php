<?php

namespace App\Console;

use App\Attendance\Jobs\CheckAttendanceSchedule;
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
        \App\Attendance\Console\Commands\AttendanceScheduleChecker::class
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
        $this->scheduleOnDayCommands($schedule);
    }


    protected function scheduleInDayCommands(Schedule $schedule)
    {
//        $schedule->job(new CheckAttendanceSchedule)->everyMinute();
        $schedule->command('attendance:check-schedule')->everyMinute();
    }

    protected function scheduleDailyCommands(Schedule $schedule)
    {
//        $schedule->command('products:set-rating')->dailyAt('02:30');
//        $schedule->command('service:generators:sitemap')->dailyAt('00:35');
//        $schedule->command('send:daily-emails')->dailyAt('00:00');
    }

    protected function scheduleOnDayCommands(Schedule $schedule)
    {
//        $schedule->command('client:mail:send-bonus-notifications')->weekdays()->at('10:00');
    }


    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
