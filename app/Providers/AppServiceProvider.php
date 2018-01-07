<?php

namespace App\Providers;

use App\Account\Models\User;
use App\Account\Observer\UserObserver;
use App\Attendance\Models\AttendanceTimesheet;
use App\Attendance\Observer\TimesheetObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191); // fix for DB MySQL < 5.7 conflicts
        User::observe(UserObserver::class);
        AttendanceTimesheet::observe(TimesheetObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Passport::ignoreMigrations();
    }
}
