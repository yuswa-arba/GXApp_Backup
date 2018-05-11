<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeBonusesCutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeeBonusesCuts', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('employeeId');
            $table->integer('salaryBonusCutTypeId');
            $table->string('value')->nullable();
            $table->tinyInteger('isUsingFormula')->default(0);
            $table->string('formula')->nullable();
            $table->tinyInteger('isActive')->default(0);
            $table->string('insertedDate');
            $table->string('insertedBy');
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
        Schema::dropIfExists('employeeBonusesCuts');
    }
}
