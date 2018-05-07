<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SlotTableSeeder extends Seeder
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
                'name'=>'General_1',
                'positionOrder'=>'1',
                'allowMultipleAssign'=>'1',
                'slotMakerId'=>'1',
                'isUsingMapping'=>'0',
                'isDeleted'=>'0',
            ]
        );


        if(DB::table('slots')->where('id',1)->first()){
            DB::table('slots')->where('id',1)->update($data);
        } else {
            DB::table('slots')->insert($data);
        }
    }
}
