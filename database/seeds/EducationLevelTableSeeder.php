<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EducationLevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['id' => '1', 'name' => 'Elementary School'],
            ['id' => '2', 'name' => 'Junior High School'],
            ['id' => '3', 'name' => 'Senior High School'],
            ['id' => '4', 'name' => 'Associate\'s Degree'],
            ['id' => '5', 'name' => 'Bachelor\'s Degree'],
            ['id' => '6', 'name' => 'Master\'s Degree'],
            ['id' => '7', 'name' => 'Doctorate\'s Degree'],
            ['id' => '8', 'name' => 'Vocational School']
        );

        /* Truncate all the data before populating*/
        if (DB::table('educationLevel')->get()->count() > 0) {
            DB::table('educationLevel')->truncate();
        }

        DB::table('educationLevel')->insert($data);
    }
}
