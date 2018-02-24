<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorageRequestCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storageRequestCart', function (Blueprint $table) {
            $table->increments('id');
            $table->string('employeeId');
            $table->integer('itemId');
            $table->string('amount');
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('storageRequestCart');
    }
}
