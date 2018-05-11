<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDivisionManagerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('divisionManager', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('employeeId');
            $table->integer('divisionId');
            $table->integer('branchOfficeId');
            $table->tinyInteger('isActive')->default(0);
            $table->string('startDate');
            $table->string('endDate');
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
        Schema::dropIfExists('divisionManager');
    }
}
