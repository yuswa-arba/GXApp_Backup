<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportProblemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reportProblem', function (Blueprint $table) {
            $table->increments('id');
            $table->string('from');
            $table->integer('typeId')->nullable();
            $table->string('problem')->nullable();
            $table->string('solution')->nullable();
            $table->tinyInteger('isSolved')->default(0);
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
        Schema::dropIfExists('reportProblem');
    }
}
