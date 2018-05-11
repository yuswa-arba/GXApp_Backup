<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logRequest', function (Blueprint $table) {
            $table->increments('id');
            $table->string('causer');
            $table->string('via'); // api client / web client
            $table->string('causerIPAddress')->nullable();
            $table->string('subject');
            $table->string('action'); // read/update/insert/delete/auth
            $table->tinyInteger('level'); //1 - 3 (1 is more important than 3)
            $table->text('description');
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
        Schema::dropIfExists('logRequest');
    }
}
