<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalaryQueueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaryQueue', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('employeeId');
            $table->integer('salaryBonusCutTypeId');
            $table->string('value');
            $table->string('fromDate');
            $table->string('toDate');
            $table->string('notes');
            $table->string('insertedDate');
            $table->string('insertedBy');
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
        Schema::dropIfExists('salaryQueue');
    }
}
