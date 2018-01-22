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
            $table->uuid('employeeId');
            $table->tinyInteger('leaveTypeId');
            $table->tinyInteger('leaveApprovalId');
            $table->string('description');
            $table->string('fromDate');
            $table->string('toDate');
            $table->integer('totalDays');
            $table->integer('year');
            $table->string('answer');
            $table->string('answeredBy');
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
