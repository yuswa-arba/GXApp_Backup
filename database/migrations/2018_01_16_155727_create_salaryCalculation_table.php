<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalaryCalculationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaryCalculation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('salaryReportId');
            $table->uuid('employeeId');
            $table->integer('salaryBonusCutTypeId');
            $table->string('value');
            $table->integer('appliedAtMonth');
            $table->integer('appliedAtYear');
            $table->string('notes');
            $table->string('insertedDate');
            $table->string('insertedBy');
            $table->string('processedDate')->nullable();
            $table->tinyInteger('isCanceled')->default(0);
            $table->string('canceledDate')->nullable();
            $table->string('canceledBy')->nullable();
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
        Schema::dropIfExists('salaryCalculation');
    }
}
