<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = array(
            ['name' => 'CSO'],
            ['name' => 'CTSO'],
            ['name' => 'Marketing'],
            ['name' => 'MNT Technicians'],
            ['name' => 'FO Technicians'],
            ['name' => 'WL Technicians'],
            ['name' => 'Household'],
            ['name' => 'Storage'],
            ['name' => 'NA']
        );

        /* Truncate all the data before populating*/
        if (DB::table('divisions')->get()->count() > 0) {
            DB::table('divisions')->truncate();
        }

        DB::table('divisions')->insert($data);
    }
}
