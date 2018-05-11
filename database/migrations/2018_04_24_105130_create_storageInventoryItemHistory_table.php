<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorageInventoryItemHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storageInventoryItemHistory', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inventoryItemId');
            $table->string('serialNumber')->nullable();
            $table->integer('quantity');
            $table->tinyInteger('actionTypeId');
            $table->integer('fromInventoryTypeId')->nullable();
            $table->integer('toInventoryTypeId')->nullable();
            $table->string('description');
            $table->string('insertedBy');
            $table->string('insertedAt');
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
        Schema::dropIfExists('storageInventoryItemHistory');
    }
}
