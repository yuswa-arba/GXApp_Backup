<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReligionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['name' => 'Christianity'],
            ['name' => 'Islam'],
            ['name' => 'Catholicism'],
            ['name' => 'Buddhism'],
            ['name' => 'Hinduism']
        );

        /* Truncate all the data before populating*/
        if (DB::table('religions')->get()->count() > 0) {
            DB::table('religions')->truncate();
        }

        DB::table('religions')->insert($data);
    }
}
