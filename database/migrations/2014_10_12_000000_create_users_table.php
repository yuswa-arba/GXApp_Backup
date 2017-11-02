<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('employeeId');
            $table->tinyInteger('userLevelId')->default(1);
            $table->tinyInteger('accessStatusId')->default(1);
            $table->string('email')->unique();
            $table->string('password');
            $table->tinyInteger('allowUserAccess')->default(1);
            $table->tinyInteger('allowAdminAccess')->default(0);
            $table->tinyInteger('allowSuperAdminAccess')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
