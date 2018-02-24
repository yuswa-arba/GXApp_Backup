<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorageStockAuditTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storageStockAudit', function (Blueprint $table) {
            $table->increments('id');
            $table->string('itemCode');
            $table->integer('currentStock');
            $table->integer('minimumStock');
            $table->tinyInteger('allowNotification')->default(0);
            $table->string('lastUpdatedAt');
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
        Schema::dropIfExists('storageStockAudit');
    }
}
