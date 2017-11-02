<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmploymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employment', function (Blueprint $table) {
            $table->increments('id');
            $table->string('employeeId')->unique();
            $table->tinyInteger('jobPositionId');
            $table->tinyInteger('divisionId');
            $table->tinyInteger('activityStatusId');
            $table->tinyInteger('branchOfficeId');
            $table->tinyInteger('recruitmentStatusId');
            $table->date('dateOfEntry');
            $table->date('dateOfStart');
            $table->date('dateOfResignation');
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
        Schema::dropIfExists('employment');
    }
}