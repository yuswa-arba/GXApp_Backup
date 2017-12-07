<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTakenDayOffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('takenDayOffs', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('employeeId');
            $table->integer('dayOffScheduleId');
            $table->string('takenCause')->nullable();
            $table->tinyInteger('isTakenApproved')->default(0);
            $table->string('takenBy')->nullable();
            $table->string('takenAt')->nullable();
            $table->string('changedDate')->nullable();
            $table->tinyInteger('isChangedDateApproved')->default(0);
            $table->string('approvedBy')->nullable();
            $table->string('approvedAt')->nullable();
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
        Schema::dropIfExists('takenDayOffs');
    }
}
