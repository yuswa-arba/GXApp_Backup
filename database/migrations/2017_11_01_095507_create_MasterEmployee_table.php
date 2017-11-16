<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('MasterEmployee', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('employeeNo')->unique();
            $table->string('givenName');
            $table->string('surname');
            $table->string('nickName');
            $table->string('birthDate');
            $table->string('gender');
            $table->tinyInteger('religionId');
            $table->string('city');
            $table->string('address');
            $table->string('email')->unique();
            $table->string('altEmail')->nullable();
            $table->string('phoneNo')->unique();
            $table->tinyInteger('educationLevelId');
            $table->tinyInteger('maritalStatusId');
            $table->string('spousesName')->nullable();
            $table->tinyInteger('totalChildren')->default(0);
            $table->string('idCardNumber');
            $table->string('idCardPhoto')->nullable();
            $table->string('employeePhoto')->nullable();
            $table->string('fatherName');
            $table->string('fatherAddress');
            $table->string('fatherPhoneNo');
            $table->tinyInteger('fatherMaritalStatusId');
            $table->string('motherName');
            $table->string('motherAddress');
            $table->string('motherPhoneNo');
            $table->tinyInteger('motherMaritalStatusId');
            $table->tinyInteger('numberOfSiblings')->default(0);
            $table->string('siblingName')->nullable();
            $table->string('siblingAddress')->nullable();
            $table->string('siblingPhoneNo')->nullable();
            $table->tinyInteger('siblingMaritalStatusId')->nullable();
            $table->string('emergencyContact');
            $table->string('emergencyRelationship');
            $table->string('emergencyAddress');
            $table->string('emergencyPhoneNo');
            $table->string('emergencyAltPhoneNo')->nullable();
            $table->string('emergencyEmailAddress');
            $table->string('prevCompanyName')->nullable();
            $table->string('prevCompanyAddress')->nullable();
            $table->string('prevCompanyPhoneNo')->nullable();
            $table->string('prevPosition')->nullable();
            $table->string('prevLengthEmployment')->nullable();
            $table->tinyInteger('bankId')->nullable();
            $table->string('bankAccNo')->nullable();
            $table->string('bankHolderName')->nullable();
            $table->string('bankBranch')->nullable();
            $table->string('bankCity')->nullable();
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
        Schema::dropIfExists('MasterEmployee');
    }
}
