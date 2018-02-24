<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorageSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storageSuppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address');
            $table->string('country');
            $table->string('city');
            $table->string('postalCode');
            $table->string('telephoneNumber')->nullable();
            $table->string('contactPerson1')->nullable();
            $table->string('mobileNumber1')->nullable();
            $table->string('email1')->nullable();
            $table->string('contactPerson2')->nullable();
            $table->string('mobileNumber2')->nullable();
            $table->string('email2')->nullable();
            $table->string('accountingNumber');
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('storageSuppliers');
    }
}
