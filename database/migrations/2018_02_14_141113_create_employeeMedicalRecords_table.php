<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeMedicalRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeeMedicalRecords', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('employeeId');
            $table->tinyInteger('hasLongTermMedication')->default(0);
            $table->string('typeOfDisease')->nullable();
            $table->string('medicationSinceWhen')->nullable();
            $table->string('typeOfDrug')->nullable();
            $table->tinyInteger('isASmoker')->default(0);
            $table->string('smokeAmountPerDay')->nullable();
            $table->string('smokingSinceWhen')->nullable();
            $table->tinyInteger('isADrinker')->default(0);
            $table->string('drinkAmountPerDay')->nullable();
            $table->string('drinkingSinceWhen')->nullable();
            $table->tinyInteger('hadAnAccident')->default(0);
            $table->string('accidentDate')->nullable();
            $table->string('typeOfAccident')->nullable();
            $table->tinyInteger('hadASurgery')->nullable();
            $table->string('surgeryDate')->nullable();
            $table->string('typeOfSurgery')->nullable();
            $table->tinyInteger('hasHospitalized')->default(0);
            $table->string('dateHospitalized')->nullable();
            $table->string('typeOfMedication')->nullable();
            $table->string('dietaryHabit')->nullable();
            $table->string('typeOfSport')->nullable();
            $table->string('sportAmountPerWeek')->nullable();
            $table->string('bodyHeight')->nullable();
            $table->tinyInteger('wearGlasses')->default(0);
            $table->string('glassesSize')->nullable();
            $table->string('extraNotes')->nullable();
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
        Schema::dropIfExists('employeeMedicalRecords');
    }
}
