<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalaryBonusCutTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaryBonusCutType', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('addOrSub'); // "add" / "sub"
            $table->tinyInteger('isRelatedToDivision')->default(0);
            $table->integer('divisionId')->nullable();
            $table->tinyInteger('isDeleted')->default(0);
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
        Schema::dropIfExists('salaryBonusCutType');
    }
}
