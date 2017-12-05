<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlotShiftSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slotShiftSetting', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->tinyInteger('slotId');
            $table->tinyInteger('shiftId');
            $table->tinyInteger('week');
            $table->tinyInteger('month');
            $table->integer('year');
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
        Schema::dropIfExists('slotShiftSetting');
    }
}
