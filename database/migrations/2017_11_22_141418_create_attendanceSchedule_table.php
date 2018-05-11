<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendanceSchedule', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shiftId');
            $table->tinyInteger('allowedToCheckIn')->default(0);
            $table->tinyInteger('allowedToCheckOut')->default(0);
            $table->tinyInteger('allowedToBreakIn')->default(0);
            $table->tinyInteger('allowedToBreakOut')->default(0);
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
        Schema::dropIfExists('attendanceSchedule');
    }
}
