<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialOccassionScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialOccassionSchedule', function (Blueprint $table) {
            $table->increments('id');
            $table->string('date');
            $table->string('startTime');
            $table->string('endTime');
            $table->tinyInteger('allDay');
            $table->string('description');
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
        Schema::dropIfExists('specialOccassionSchedule');
    }
}
