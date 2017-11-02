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
            $table->string('lastName');
            $table->string('nickName');
            $table->date('birthDate');
            $table->string('gender');
            $table->tinyInteger('religionId');
            $table->string('city');
            $table->string('address');
            $table->string('email')->unique();
            $table->string('altEmail');
            $table->string('phoneNo')->unique();
            $table->tinyInteger('educationLevelId');
            $table->tinyInteger('maritalStautsId');
            $table->string('spousesName');
            $table->tinyInteger('totalChildren');
            $table->string('idCardNumber');
            $table->binary('idCardPhoto')->nullable();
            $table->binary('employeePhoto')->nullable();
            $table->string('fatherName');
            $table->string('fatherAddress');
            $table->string('fatherPhoneNo');
            $table->tinyInteger('fatherMaritalStatusId');
            $table->string('motherName');
            $table->string('motherAddress');
            $table->string('motherPhoneNo');
            $table->tinyInteger('motherMaritalStatusId');
            $table->tinyInteger('numberOfSiblings');
            $table->string('siblingName');
            $table->string('siblingAddress');
            $table->string('siblingPhoneNo');
            $table->tinyInteger('siblingMaritalStatusId');
            $table->string('emergencyContact');
            $table->string('emergencyRelationship');
            $table->string('emergencyPhoneNo');
            $table->string('emergencyAltPhoneNo');
            $table->string('emergencyEmailAddress');
            $table->string('prevCompanyName')->nullable();
            $table->string('prevCompanyAddress')->nullable();
            $table->string('prevCompanyPhoneNo')->nullable();
            $table->string('prevPosition')->nullable();
            $table->string('prevLengthEmployment')->nullable();
            $table->string('bankId');
            $table->string('bankAccNo');
            $table->string('bankHolderName');
            $table->string('bankBranch');
            $table->string('bankCity');
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
