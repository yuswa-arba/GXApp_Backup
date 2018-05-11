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
            ['id' => '1', 'name' => 'CSO'],
            ['id' => '2', 'name' => 'CTSO'],
            ['id' => '3', 'name' => 'Marketing'],
            ['id' => '4', 'name' => 'MNT Technicians'],
            ['id' => '5', 'name' => 'FO Technicians'],
            ['id' => '6', 'name' => 'WL Technicians'],
            ['id' => '7', 'name' => 'Household'],
            ['id' => '8', 'name' => 'Storage'],
            ['id' => '9', 'name' => 'NA'],
            ['id' => '10', 'name' => 'Secretary'],
            ['id' => '11', 'name' => 'R&D '],
            ['id' => '12', 'name' => 'Development'],
            ['id' => '13', 'name' => 'Secretary'],
            ['id' => '14', 'name' => 'Development'],

        );

        /* Truncate all the data before populating*/
        if (DB::table('divisions')->get()->count() > 0) {
            DB::table('divisions')->truncate();
        }

        DB::table('divisions')->insert($data);
    }
}
