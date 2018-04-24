<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CraeteStorageInventoryItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storageInventoryItem', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('itemId');
            $table->integer('branchOfficeId');
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
        Schema::dropIfExists('storageInventoryItem');
    }
}
