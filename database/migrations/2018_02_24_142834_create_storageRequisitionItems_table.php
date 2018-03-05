<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorageRequisitionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storageRequisitionItems', function (Blueprint $table) {
            $table->increments('id');
            $table->string('requisitionNumber');
            $table->string('employeeId');
            $table->integer('itemId');
            $table->string('amount');
            $table->string('notes')->nullable();
            $table->string('insertedAt');
            $table->tinyInteger('isApproved')->default(0);
            $table->string('updatedAt')->nullable();
            $table->string('updatedBy')->nullable();
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
        Schema::dropIfExists('storageRequisitionItems');
    }
}
