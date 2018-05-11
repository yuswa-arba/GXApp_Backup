<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResignationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resignation', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('employeeId');
            $table->string('submissionDate')->nullable();
            $table->string('effectiveDate');
            $table->string('resignationLetter')->nullable();
            $table->string('professionalism');
            $table->string('reason')->nullable();
            $table->string('notes')->nullable();
            $table->string('submittedBy')->nullable();
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
        Schema::dropIfExists('resignation');
    }
}
