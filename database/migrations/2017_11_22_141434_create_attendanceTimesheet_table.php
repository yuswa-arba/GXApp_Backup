<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceTimesheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendanceTimesheet', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('employeeId');
            $table->string('clockInDate')->nullablle();
            $table->string('clockOutDate')->nullablle();
            $table->string('clockInTime')->nullablle();
            $table->string('clockOutTime')->nullable();
            $table->string('breakInTime')->nullable();
            $table->string('breakOutTime')->nullable();
            $table->tinyInteger('clockInViaTypeId');
            $table->tinyInteger('clockOutViaTypeId');
            $table->string('employeePhotoClockIn')->nullable();
            $table->string('employeePhotoClockOut')->nullable();
            $table->tinyInteger('clockInValidGeofence')->nullable();
            $table->tinyInteger('clockOutValidGeofence')->nullable();
            $table->string('clockInLatitude')->nullable();
            $table->string('clockInLongitude')->nullable();
            $table->string('clockOutLatitude')->nullable();
            $table->string('clockOutLongitude')->nullable();
            $table->tinyInteger('clockInKioskId')->nullable();
            $table->tinyInteger('clockOutKioskId')->nullable();
            $table->ipAddress('clockInIpAddress')->nullable();
            $table->ipAddress('clockOutIpAddress')->nullable();
            $table->string('clockInBrowser')->nullable();
            $table->string('clockOutBrowser')->nullable();
            $table->tinyInteger('attendanceApproveId');
            $table->string('approvedBy')->nullable();
            $table->tinyInteger('attendanceValidationId')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendanceTimesheet');
    }
}
