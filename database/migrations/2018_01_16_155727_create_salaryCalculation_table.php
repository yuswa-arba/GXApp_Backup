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
            $table->string('fromDate');
            $table->string('toDate');
            $table->string('notes');
            $table->string('insertedDate');
            $table->string('insertedBy');
            $table->tinyInteger('isEdited')->default(0);
            $table->string('editedDate')->nullable();
            $table->string('editedBy')->nullable();
            $table->tinyInteger('isDeleted')->default(0);
            $table->string('deletedDate')->nullable();
            $table->string('deletedBy')->nullable();
            $table->tinyInteger('isProcessed')->default(0);
            $table->string('processedDate')->nullable();
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
