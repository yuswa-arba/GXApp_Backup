<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchOfficesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['name' => 'Bali'],
            ['name' => 'Malang'],
            ['name' => 'Balikpapan'],
            ['name' => 'Samarinda']);

        /* Truncate all the data before populating*/
        if (DB::table('branchOffices')->get()->count() > 0) {
            DB::table('branchOffices')->truncate();
        }

        DB::table('branchOffices')->insert($data);
    }
}
