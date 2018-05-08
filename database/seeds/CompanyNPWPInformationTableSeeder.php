<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyNPWPInformationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = array(
            [
               'id'=>'1',
               'npwpNo'=>'01.901.977.7-906.000',
               'companyName'=>'PT INTERNET MADJU ABAD MILENINDO',
               'companyAddress'=>'JL RAYA KEROBOKAN 388X KEROBOKAN, KUTA UTARA - BADUNG',
               'dateRegistered'=>'06-05-2009',
               'npwpPhoto'=>'PT-IMAM-NPWP.jpeg',
            ]
        );

        /* Truncate all the data before populating*/
        if (DB::table('companyNPWPInformation')->get()->count() > 0) {
            DB::table('companyNPWPInformation')->truncate();
        }

        DB::table('companyNPWPInformation')->insert($data);
    }
}
