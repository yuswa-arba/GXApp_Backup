<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentTermsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['id'=>'1','name' => 'PIA','description'=>'Payment in advance'],
            ['id'=>'2','name' => 'EOM','description'=>'End of month'],
            ['id'=>'3','name' => 'COD','description'=>'Cash on delivery'],
            ['id'=>'4','name' => 'Cash Account','description'=>'Account conducted on a cash basis, no credit'],
            ['id'=>'5','name' => 'Bill of exchange','description'=>'A promise to pay at a later date, usually supported by a bank'],
            ['id'=>'6','name' => 'Stage payment','description'=>'Payment of agreed amounts at stage'],
            ['id'=>'7','name' => 'CND','description'=>'Cash next delivery'],
            ['id'=>'8','name' => 'CIA','description'=>'Cash in advance'],
            ['id'=>'9','name' => 'CWO','description'=>'Cash with order'],
            ['id'=>'10','name' => 'Contra','description'=>'Payment from the customer offset against the value of supplies purchased from the customer'],
            ['id'=>'11','name' => 'Letter of credit','description'=>'A documentary credit confirmed by a bank, often used for export'],
        );

        /* Truncate all the data before populating*/
        if (DB::table('paymentTerms')->get()->count() > 0) {
            DB::table('paymentTerms')->truncate();
        }

        DB::table('paymentTerms')->insert($data);
    }
}
