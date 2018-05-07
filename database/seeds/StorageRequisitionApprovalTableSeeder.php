<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StorageRequisitionApprovalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['id' => '1', 'name' => 'Approved'],
            ['id' => '2', 'name' => 'Declined'],
            ['id' => '3', 'name' => 'Waiting For Approval'],
            ['id' => '4', 'name' => 'In Proccess'],
            ['id' => '5', 'name' => 'Finish'],

        );

        /* Truncate all the data before populating*/
        if (DB::table('storageRequisitionApproval')->get()->count() > 0) {
            DB::table('storageRequisitionApproval')->truncate();
        }

        DB::table('storageRequisitionApproval')->insert($data);
    }
}
