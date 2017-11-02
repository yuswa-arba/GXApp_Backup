<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call([
            AccessStatusTableSeeder::class,
            BanksTableSeeder::class,
            BranchOfficesTableSeeder::class,
            DivisionsTableSeeder::class,
            EducationLevelTableSeeder::class,
            EmployeeStatusTableSeeder::class,
            MaritalStatusTableSeeder::class,
            RecruitmentStatusTableSeeder::class,
            ReligionsTableSeeder::class,
            JobPositionsTableSeeder::class
//            userLevelTableSeeder::class,
//            activityStatusTableSeeder::class
        ]);
    }
}
