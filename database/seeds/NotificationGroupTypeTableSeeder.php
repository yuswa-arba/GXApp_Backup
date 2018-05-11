<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationGroupTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['id'=>'1','name' => 'General'],
            ['id'=>'2','name' => 'Requisition Storage'],
            ['id'=>'3','name' => 'Tracking Order Storage'],
            ['id'=>'4','name' => 'New Requisition'],
        );

        /* Truncate all the data before populating*/
        if (DB::table('notificationGroupType')->get()->count() > 0) {
            DB::table('notificationGroupType')->truncate();
        }

        DB::table('notificationGroupType')->insert($data);
    }
}
