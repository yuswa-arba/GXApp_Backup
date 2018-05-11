<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicHolidayScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publicHolidaySchedule', function (Blueprint $table) {
            $table->increments('id');
            $table->string('employeeId');
            $table->integer('pubHolidayId');
            $table->string('originalDate');
            $table->string('applyDate');
            $table->integer('positionOrder');
            $table->integer('fromSlotId');
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
        Schema::dropIfExists('publicHolidaySchedule');
    }
}
