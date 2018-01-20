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
            $table->string('fromDate');
            $table->string('toDate');
            $table->string('description');
            $table->tinyInteger('leaveApprovalId');
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
