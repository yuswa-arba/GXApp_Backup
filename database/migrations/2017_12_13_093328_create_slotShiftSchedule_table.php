<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlotShiftScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slotShiftSchedule', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('slotId');
            $table->integer('shiftId');
            $table->string('date');
            $table->tinyInteger('isOverwrite')->default(0);
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
        Schema::dropIfExists('slotShiftSchedule');
    }
}
