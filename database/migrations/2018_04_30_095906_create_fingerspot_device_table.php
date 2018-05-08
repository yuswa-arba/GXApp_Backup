<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFingerspotDeviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fingerspotDevice', function (Blueprint $table) {
            $table->increments('id');
            $table->string('server_ip');
            $table->string('server_port');
            $table->string('device_sn');
            $table->string('description')->nullable();
            $table->tinyInteger('is_activated')->default(0);
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
        Schema::dropIfExists('fingerspotDevice');
    }
}
