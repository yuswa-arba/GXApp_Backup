<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SlotMakerTableSeeder extends Seeder
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
                'name'=>'General',
                'firstDate'=>'01/01/2018',
                'relatedToJobPosition'=>'0',
                'jobPositionId'=>'',
                'totalDayLoop'=>'1',
                'workingDays'=>'6',
                'allowMultipleAssign'=>'1',
                'isExecuted'=>'1',
                'executedAt'=>'',
                'executedBy'=>'',
            ]
        );


        if(DB::table('slotMaker')->where('id',1)->first()){
            DB::table('slotMaker')->where('id',1)->update($data);
        } else {
            DB::table('slotMaker')->insert($data);
        }
    }
}
