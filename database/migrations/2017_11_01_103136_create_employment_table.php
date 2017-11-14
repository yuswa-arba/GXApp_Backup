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
            $table->tinyInteger('branchOfficeId');
            $table->tinyInteger('recruitmentStatusId');
            $table->string('dateOfEntry');
            $table->string('dateOfStart');
            $table->string('dateOfResignation');
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
