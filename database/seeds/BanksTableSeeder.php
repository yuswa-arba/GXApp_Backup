<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = array(
            ['name' => 'Bank Rakyat Indonesia (BRI)'],
            ['name' => 'Bank Mandiri'],
            ['name' => 'Bank Central Asia (BCA)'],
            ['name' => 'Bank Negara Indonesia (BNI)'],
            ['name' => 'Bank CIMB Niaga'],
            ['name' => 'Bank Tabungan Negara (BTN)'],
            ['name' => 'Bank Panin'],
            ['name' => 'Bank Permata'],
            ['name' => 'Bank International Indonesia (BII)'],
            ['name' => 'Bank Danamon']
        );

        /* Truncate all the data before populating*/
        if (DB::table('banks')->get()->count() > 0) {
            DB::table('banks')->truncate();
        }

        DB::table('banks')->insert($data);
    }
}
