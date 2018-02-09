<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExchangeSlotEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchangeSlotEmployee', function (Blueprint $table) {
            $table->increments('id');
            $table->string('employeeId1');
            $table->tinyInteger('fromSlotId')->nullable();
            $table->string('employeeId2');
            $table->tinyInteger('toSlotId')->nullable();
            $table->string('fromDates');
            $table->tinyInteger('isDayOff')->default(0);
            $table->string('toDates');
            $table->tinyInteger('slotApproveId');
            $table->string('approvedBy');
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
        Schema::dropIfExists('exchangeSlotEmployee');
    }
}
