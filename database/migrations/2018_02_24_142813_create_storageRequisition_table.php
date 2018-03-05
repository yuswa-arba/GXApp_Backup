<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorageRequisitionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storageRequisition', function (Blueprint $table) {
            $table->increments('id');
            $table->string('requisitionNumber');
            $table->string('approvalNumber')->nullable();
            $table->string('requestedAt');
            $table->string('requestedBy');
            $table->string('dateNeededBy');
            $table->integer('divisionId')->nullable();
            $table->integer('deliveryWarehouseId');
            $table->string('description');
            $table->integer('approvalId')->default(0);
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
        Schema::dropIfExists('storageRequisition');
    }
}
