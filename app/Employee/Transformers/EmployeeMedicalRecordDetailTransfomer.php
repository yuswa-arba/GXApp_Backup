<?php

namespace App\Employee\Transformers;

use App\Employee\Models\EmployeeMedicalRecords;
use League\Fractal\TransformerAbstract;

class EmployeeMedicalRecordDetailTransfomer extends TransformerAbstract
{

    public function transform(EmployeeMedicalRecords $medicalRecords)
    {
        return [
            'id'=>$medicalRecords->id,
            'employeeId'=>$medicalRecords->employeeId,
            'hasLongTermMedication'=>$medicalRecords->hasLongTermMedication,
            'typeOfDisease'=>$medicalRecords->typeOfDisease,
            'medicationSinceWhen'=>$medicalRecords->medicationSinceWhen,
            'typeOfDrug'=>$medicalRecords->typeOfDrug,
            'isASmoker'=>$medicalRecords->isASmoker,
            'smokeAmountPerDay'=>$medicalRecords->smokeAmountPerDay,
            'smokingSinceWhen'=>$medicalRecords->smokingSinceWhen,
            'isADrinker'=>$medicalRecords->isADrinker,
            'drinkAmountPerDay'=>$medicalRecords->drinkAmountPerDay,
            'drinkingSinceWhen'=>$medicalRecords->drinkingSinceWhen,
            'hadAnAccident'=>$medicalRecords->hadAnAccident,
            'accidentDate'=>$medicalRecords->accidentDate,
            'typeOfAccident'=>$medicalRecords->typeOfAccident,
            'hadASurgery'=>$medicalRecords->hadASurgery,
            'surgeryDate'=>$medicalRecords->surgeryDate,
            'typeOfSurgery'=>$medicalRecords->typeOfSurgery,
            'hasHospitalized'=>$medicalRecords->hasHospitalized,
            'dateHospitalized'=>$medicalRecords->dateHospitalized,
            'typeOfMedication'=>$medicalRecords->typeOfMedication,
            'dietaryHabit'=>$medicalRecords->dietaryHabit,
            'typeOfSport'=>$medicalRecords->typeOfSport,
            'sportAmountPerWeek'=>$medicalRecords->sportAmountPerWeek,
            'bodyHeight'=>$medicalRecords->bodyHeight,
            'wearGlasses'=>$medicalRecords->wearGlasses,
            'glassesSize'=>$medicalRecords->glassesSize,
            'extraNotes'=>$medicalRecords->extraNotes,
        ];
    }





}
