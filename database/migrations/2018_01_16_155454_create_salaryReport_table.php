<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalaryReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaryReport', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('employeId');
            $table->integer('month');
            $table->string('fromDate');
            $table->string('toDate');
            $table->string('basicSalary');
            $table->string('totalEarnings');
            $table->string('totalSalaryCut');
            $table->tinyInteger('isConfirmed')->default(0);
            $table->string('confirmedDate')->nullable();
            $table->tinyInteger('isSubmittedForPayroll')->default(0);
            $table->integer('generatePayrollId');
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
        Schema::dropIfExists('salaryReport');
    }
}
