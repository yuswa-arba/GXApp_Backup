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
            $table->uuid('employeeId');
            $table->string('fromDate');
            $table->string('toDate');
            $table->string('basicSalary');
            $table->string('totalSalaryBonus');
            $table->string('totalSalaryCut');
            $table->string('salaryReceived');
            $table->tinyInteger('confirmationStatusId')->default(3);
            $table->string('confirmationDate')->nullable();
            $table->tinyInteger('isPostponed')->default(0);
            $table->tinyInteger('isSubmittedForPayroll')->default(0);
            $table->integer('generatePayrollId')->nullable();
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
