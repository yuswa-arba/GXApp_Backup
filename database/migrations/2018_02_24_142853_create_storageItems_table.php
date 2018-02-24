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
            $table->integer('categoryId');
            $table->string('accountingNumber');
            $table->string('itemTypeCode');
            $table->integer('reminder1')->nullable();
            $table->integer('reminder2')->nullable();
            $table->integer('minimumStock');
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
