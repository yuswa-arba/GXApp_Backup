<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeLeaveScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeeLeaveSchedule', function (Blueprint $table) {
            $table->increments('id');
            $table->string('employeeId');
            $table->tinyInteger('leaveTypeId');
            $table->tinyInteger('leaveApprovalId');
            $table->string('description')->nullable();
            $table->string('fromDate');
            $table->string('toDate');
            $table->integer('totalDays');
            $table->integer('month');
            $table->integer('year');
            $table->string('answer')->nullable();
            $table->string('answeredBy');
            $table->tinyInteger('isStreakPaidLeave')->default(0);
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
        Schema::dropIfExists('employeeLeaveSchedule');
    }
}
