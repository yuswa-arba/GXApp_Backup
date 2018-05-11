<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePushNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('userId');
            $table->string('title')->nullable();
            $table->string('message');
            $table->string('intentType')->nullable();//only applicable for android
            $table->string('viaType')->nullable();
            $table->integer('groupTypeId')->default(1);
            $table->string('url')->nullable();//applicalbe for web only
            $table->string('sendBy');
            $table->string('sendDate');
            $table->string('sendTime');
            $table->tinyInteger('hasSeen')->default(0);
            $table->string('seenDate')->nullable();
            $table->string('seenTime')->nullable();
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
        Schema::dropIfExists('pushNotifications');
    }
}
