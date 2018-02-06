<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExchangeShiftEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchangeShiftEmployee', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('employeeId1'); // requester
            $table->integer('fromShiftId');
            $table->uuid('employeeId2'); // owner
            $table->integer('toShiftId');
            $table->string('date');
            $table->tinyInteger('isConfirmed')->default(0);
            $table->string('confirmedDate')->nullable();
            $table->string('confirmedTime')->nullable();
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
        Schema::dropIfExists('exchangeShiftEmployee');
    }
}
