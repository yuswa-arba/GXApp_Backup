<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorageItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storageItems', function (Blueprint $table) {
            $table->increments('id');
            $table->string('itemCode')->unique();
            $table->string('name');
            $table->integer('unitId');
            $table->string('itemTypeCode');
            $table->string('categoryCode');
            $table->string('accountingNumber');
            $table->integer('itemNumber');
            $table->integer('reminder1')->nullable();
            $table->integer('reminder2')->nullable();
            $table->integer('minimumStock')->default(0);
            $table->tinyInteger('allowNotification')->default(0);
            $table->integer('statusId');
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
        Schema::dropIfExists('storageItems');
    }
}
