<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['id' => '1', 'name' => 'admin', 'guard_name' => 'web'],
            ['id' => '2', 'name' => 'superAdmin', 'guard_name' => 'web'],
            ['id' => '3', 'name' => 'user', 'guard_name' => 'web'],
            ['id' => '4', 'name' => 'CSO Trainee', 'guard_name' => 'web'],
            ['id' => '5', 'name' => 'Cashier', 'guard_name' => 'web'],
            ['id' => '6', 'name' => 'CSO Senior', 'guard_name' => 'web'],
            ['id' => '7', 'name' => 'attendance operator', 'guard_name' => 'web'],
            ['id' => '8', 'name' => 'developer', 'guard_name' => 'web'],
        );

        /* Truncate all the data before populating*/
        if (DB::table('roles')->get()->count() > 0) {
            DB::table('roles')->truncate();
        }

        DB::table('roles')->insert($data);
    }
}
