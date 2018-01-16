<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneratePayrollTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generatePayroll', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fromDate');
            $table->string('toDate');
            $table->integer('branchOfficeId');
            $table->string('file');
            $table->string('generatedDate');
            $table->string('generatedBy');
            $table->string('generatedType'); // pdf , json (send to personal type)
            $table->integer('totalEmployee');
            $table->string('notes');
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
        Schema::dropIfExists('generatePayroll');
    }
}
