<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorageInventoryItemDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storageInventoryItemDetail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inventoryItemId');
            $table->string('inventoryType');
            $table->integer('quantity');
            $table->string('latestUpdateAt');
            $table->string('latestUpdateBy');
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
        Schema::dropIfExists('storageInventoryItemDetail');
    }
}
