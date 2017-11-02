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
            ['name' => 'Elementary School'],
            ['name' => 'Junior High School'],
            ['name' => 'Senior High School'],
            ['name' => 'Associate\'s Degree'],
            ['name' => 'Bachelor\'s Degree'],
            ['name' => 'Master\'s Degree'],
            ['name' => 'Doctorate\'s Degree'],
        );

        /* Truncate all the data before populating*/
        if (DB::table('educationLevel')->get()->count() > 0) {
            DB::table('educationLevel')->truncate();
        }

        DB::table('educationLevel')->insert($data);
    }
}
