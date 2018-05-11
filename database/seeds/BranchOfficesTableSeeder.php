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
            ['id'=>'1','name' => 'Bali','codeNo'=>'1','codeName'=>'GNB'],
            ['id'=>'2','name' => 'Malang','codeNo'=>'2','codeName'=>'GBP'],
            ['id'=>'3','name' => 'Balikpapan','codeNo'=>'3','codeName'=>'GNM'],
            ['id'=>'4','name' => 'Samarinda','codeNo'=>'4','codeName'=>'GSM'],
        );

        /* Truncate all the data before populating*/
        if (DB::table('branchOffices')->get()->count() > 0) {
            DB::table('branchOffices')->truncate();
        }

        DB::table('branchOffices')->insert($data);
    }
}
