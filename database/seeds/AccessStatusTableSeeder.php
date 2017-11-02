<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccessStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['name' => 'Granted'],
            ['name' => 'Blocked']
        );

        /* Truncate all the data before populating*/
        if (DB::table('accessStatus')->get()->count() > 0) {
            DB::table('accessStatus')->truncate();
        }

        DB::table('accessStatus')->insert($data);
    }
}
