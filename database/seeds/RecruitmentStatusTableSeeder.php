<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecruitmentStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['name' => 'Training'],
            ['name' => 'Internship'],
            ['name' => 'Freelance'],
            ['name' => 'Contracted'],
            ['name' => 'Permanent']
        );

        /* Truncate all the data before populating*/
        if (DB::table('recruitmentStatus')->get()->count() > 0) {
            DB::table('recruitmentStatus')->truncate();
        }

        DB::table('recruitmentStatus')->insert($data);
    }
}
