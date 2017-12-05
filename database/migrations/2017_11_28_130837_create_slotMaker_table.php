<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlotMakerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slotMaker', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('firstDate');
            $table->tinyInteger('relatedToJobPosition')->default(0);
            $table->tinyInteger('jobPositionId')->nullable();
            $table->integer('totalDayLoop');
            $table->tinyInteger('workingDays');
            $table->tinyInteger('allowMultipleAssign')->default(0);
            $table->tinyInteger('isExecuted')->default(0);
            $table->string('executedAt')->nullable();
            $table->string('executedBy')->nullable();
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
        Schema::dropIfExists('slotMaker');
    }
}
