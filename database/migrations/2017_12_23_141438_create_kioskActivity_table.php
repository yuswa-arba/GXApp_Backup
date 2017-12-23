<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKioskActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kioskActivity', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('kioskId');
            $table->string('socketId')->nullable();
            $table->tinyInteger('isLogined')->default(0);
            $table->string('lastLoginAt')->nullable();
            $table->tinyInteger('isConnectedToNetwork')->default(0);
            $table->string('lastConnectionAt')->nullable();
            $table->string('lastAPITokenRefreshAt')->nullable();
            $table->string('lastRequestURL')->nullable();
            $table->string('lastRequestAt')->nullable();
            $table->string('lastRequestBy')->nullable();
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
        Schema::dropIfExists('kioskActivity');
    }
}
