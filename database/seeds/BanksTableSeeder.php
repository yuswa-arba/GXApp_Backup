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
            ['id'=>'1','name' => 'Bank Rakyat Indonesia (BRI)'],
            ['id'=>'2','name' => 'Bank Mandiri'],
            ['id'=>'3','name' => 'Bank Central Asia (BCA)'],
            ['id'=>'4','name' => 'Bank Negara Indonesia (BNI)'],
            ['id'=>'5','name' => 'Bank CIMB Niaga'],
            ['id'=>'6','name' => 'Bank Tabungan Negara (BTN)'],
            ['id'=>'7','name' => 'Bank Panin'],
            ['id'=>'8','name' => 'Bank Permata'],
            ['id'=>'9','name' => 'Bank International Indonesia (BII)'],
            ['id'=>'10','name' => 'Bank Danamon']
        );

        /* Truncate all the data before populating*/
        if (DB::table('banks')->get()->count() > 0) {
            DB::table('banks')->truncate();
        }

        DB::table('banks')->insert($data);
    }
}
