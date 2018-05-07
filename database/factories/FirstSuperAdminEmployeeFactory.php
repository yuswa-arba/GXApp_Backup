<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\App\Employee\Models\MasterEmployee::class, function (Faker $faker) {
    static $password;

    return [
        'id'=>$faker->uuid,
        'phoneNo' => '0361736811',
        'email' => env('SUPERADMIN_EMAIL','superadmin@gxapp.net'),
        'surname' => 'GXApp',
        'givenName' => 'superadmin',
        'nickName' => 'superadmin',
        'gender' => 'male',
        'birthDate' => '01/01/2018',
        'hometown' => 'Indonesia',
        'city' => 'Bali',
        'educationLevelId' => '1',
        'religionId' => '6',
        'maritalStatusId' => '5',
        'fatherIsDeceased'=>'1',
        'motherIsDeceased'=>'1',
        'idCardNumber' => $faker->randomNumber,
        'address' => 'Jl. Raya Kerobokan 388x',
        'emergencyContact' => 'GX',
        'emergencyRelationship' => 'Friend',
        'emergencyPhoneNo' => '0361736811',
        'emergencyAddress' =>'info@globalxtreme.net',
        'emergencyCity' => 'Bali',
    ];
});