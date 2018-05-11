<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyNPWPInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companyNPWPInformation', function (Blueprint $table) {
            $table->increments('id');
            $table->string('npwpNo');
            $table->string('companyName');
            $table->string('companyAddress');
            $table->string('dateRegistered');
            $table->string('npwpPhoto')->nullable();
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
        Schema::dropIfExists('companyNPWPInformation');
    }
}
