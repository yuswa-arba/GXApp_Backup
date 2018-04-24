<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorageEntryInventoryHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storageEntryInventoryHistory', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('storagePurchaseOrderId');
            $table->integer('itemId');
            $table->integer('quantity');
            $table->integer('branchOfficeId');
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
        Schema::dropIfExists('storageEntryInventoryHistory');
    }
}
