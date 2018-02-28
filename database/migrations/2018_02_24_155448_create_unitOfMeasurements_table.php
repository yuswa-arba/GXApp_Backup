<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitOfMeasurementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unitOfMeasurements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('format');
            $table->string('description');
            $table->integer('unitOfMeasurementTypeId');
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
        Schema::dropIfExists('unitOfMeasurements');
    }
}
