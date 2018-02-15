<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKiosksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kiosks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codeName')->unique();
            $table->string('description');
            $table->string('activationCode');
            $table->string('passcode');
            $table->text('apiToken');
            $table->integer('batteryPower')->default(0)->nullable();
            $table->tinyInteger('isCharging')->default(0);
            $table->tinyInteger('isInMaintenanceMode')->default(0);
            $table->tinyInteger('isActivated')->default(0);
            $table->tinyInteger('isDeleted')->default(0);
            $table->string('lastHeartBeat')->nullable();
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
        Schema::dropIfExists('kiosks');
    }
}
