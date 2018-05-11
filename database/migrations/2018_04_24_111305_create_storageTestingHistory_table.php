<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorageTestingHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storageTestingHistory', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inventoryItemId');
            $table->integer('quantity');
            $table->string('serialNumber');
            $table->integer('testStatusId');
            $table->string('testedAt');
            $table->string('testedBy');
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
        Schema::dropIfExists('storageTestingHistory');
    }
}
