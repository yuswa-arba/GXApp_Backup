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
            $table->integer('attendanceScheduleId');
            $table->string('clockInTime');
            $table->string('clockOutTime')->nullable();
            $table->string('breakInTime')->nullable();
            $table->string('breakOutTime')->nullable();
            $table->tinyInteger('attendanceViaTypeId');
            $table->string('employeePhoto')->nullable();
            $table->tinyInteger('isWithinValidGeofence')->nullable();
            $table->string('attendanceLatitude')->nullable();
            $table->string('attendanceLongitude')->nullable();
            $table->tinyInteger('kioskId')->nullable();
            $table->ipAddress('ipAddress')->nullable();
            $table->string('browser')->nullable();
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
