<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorageEmployeeInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storageEmployeeInventory', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inventoryItemId');
            $table->integer('quantity');
            $table->string('serialNumber')->nullable();
            $table->string('employeeId');
            $table->string('employeeName');
            $table->string('finePrice')->nullable();
            $table->string('fineDescription')->nullable();
            $table->string('latestUpdateAt');
            $table->string('latestUpateBy');
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
        Schema::dropIfExists('storageEmployeeInventory');
    }
}
