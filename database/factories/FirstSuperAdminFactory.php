<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

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

$factory->define(\App\Account\Models\User::class, function (Faker $faker) {
    static $password;

    return [
        'id'=>$faker->uuid,
        'email' => env('SUPERADMIN_EMAIL','superadmin@gxapp.net'),
        'password' => $password ?: $password = Hash::make(env('SUPERADMIN_PASSWORD','secret')),
        'allowSuperAdminAccess'=>1,
        'allowAdminAccess'=>1,
        'remember_token' => str_random(10),
    ];
});