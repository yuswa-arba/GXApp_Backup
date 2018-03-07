<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoragePurchaseOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storagePurchaseOrderItems', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchaseOrderId');
            $table->tinyInteger('withRequisitionItem');
            $table->integer('requisitionItemId')->nullable();
            $table->string('amountPurchased');
            $table->integer('unitIdPurchased');
            $table->string('pricePurchased');
            $table->string('currencyFormat');
            $table->integer('validationStatusId');
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
        Schema::dropIfExists('storagePurchaseOrderItems');
    }
}
