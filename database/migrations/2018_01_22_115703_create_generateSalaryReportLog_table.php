<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenerateSalaryReportLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generateSalaryReportLog', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fromDate');
            $table->string('toDate');
            $table->tinyInteger('branchOfficeId');
            $table->string('generatedDate');
            $table->string('generatedBy');
            $table->text('salaryReportIds');
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
        Schema::dropIfExists('generateSalaryReportLog');
    }
}
