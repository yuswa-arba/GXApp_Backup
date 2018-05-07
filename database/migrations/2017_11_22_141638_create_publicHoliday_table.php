<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicHolidayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publicHoliday', function (Blueprint $table) {
            $table->increments('id');
            $table->string('date');
            $table->string('name');
            $table->tinyInteger('isGeneral')->default(1);
            $table->tinyInteger('religionId')->nullable();
            $table->tinyInteger('isApplied')->default(0);
            $table->integer('onYear')->nullable();
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
