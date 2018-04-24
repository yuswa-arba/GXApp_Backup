<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorageSalesInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storageSalesInventory', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inventoryItemId');
            $table->integer('quantity');
            $table->string('serialNumber')->nullable();
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
        Schema::dropIfExists('storageSalesInventory');
    }
}
