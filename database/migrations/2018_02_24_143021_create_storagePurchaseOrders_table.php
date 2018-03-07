<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoragePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storagePurchaseOrders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('purchaseOrderNumber')->unique();
            $table->tinyInteger('withRequisition');
            $table->integer('requisitionId')->nullable();
            $table->string('date');
            $table->integer('supplierId');
            $table->string('contactPerson')->nullable();
            $table->string('contactNumber')->nullable();
            $table->tinyInteger('withTaxInvoice')->default(0);
            $table->string('npwpNumber')->nullable();
            $table->string('notes')->nullable();
            $table->string('file')->nullable();
            $table->integer('statusId')->defaut(1);
            $table->string('insertedAt');
            $table->string('insertedBy');
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
        Schema::dropIfExists('storagePurchaseOrders');
    }
}
