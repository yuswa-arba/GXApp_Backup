<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagerEditTimesheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('managerEditTimesheet', function (Blueprint $table) {
            $table->increments('id');
            $table->string('divisionId');
            $table->string('branchOfficeId');
            $table->string('startDate');
            $table->string('endDate');
            $table->string('generatedAt');
            $table->string('generatedBy');
            $table->string('dueDate');
            $table->string('lastUpdatedAt')->nullable();
            $table->string('lastUpdatedBy')->nullable();
            $table->string('finishedAt')->nullable();
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
        Schema::dropIfExists('managerEditTimesheet');
    }
}
