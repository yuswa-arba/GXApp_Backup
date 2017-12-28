<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacePersonEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facePersonEmployee', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('personId')->unique();
            $table->uuid('employeeId');
            $table->string('personGroupId');
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
        Schema::dropIfExists('facePersonEmployee');
    }
}
