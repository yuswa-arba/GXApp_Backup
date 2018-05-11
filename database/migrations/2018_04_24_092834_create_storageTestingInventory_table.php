<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorageTestingInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storageTestingInventory', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inventoryItemId');
            $table->integer('quantity');
            $table->string('serialNumber')->nullable();
            $table->tinyInteger('testStatusId');
            $table->string('latestUpdateAt');
            $table->string('latestUpdateby');
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
        Schema::dropIfExists('storageTestingInventory');
    }
}
