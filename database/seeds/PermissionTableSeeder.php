<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['id'=>'1','name'=>'view employee','guard_name'=>'web'],
            ['id'=>'2','name'=>'create employee','guard_name'=>'web'],
            ['id'=>'3','name'=>'edit employee','guard_name'=>'web'],
            ['id'=>'4','name'=>'delete employee','guard_name'=>'web'],
            ['id'=>'5','name'=>'superadmin','guard_name'=>'web'],
            ['id'=>'6','name'=>'view setting','guard_name'=>'web'],
            ['id'=>'7','name'=>'edit setting','guard_name'=>'web'],
            ['id'=>'8','name'=>'view attendance','guard_name'=>'web'],
            ['id'=>'9','name'=>'access kiosk setting','guard_name'=>'web'],
            ['id'=>'10','name'=>'access salary','guard_name'=>'web'],
            ['id'=>'11','name'=>'generate attendance','guard_name'=>'web'],
            ['id'=>'12','name'=>'edit attendance','guard_name'=>'web'],
            ['id'=>'13','name'=>'access storage setting','guard_name'=>'web'],
            ['id'=>'14','name'=>'access misc options','guard_name'=>'web']

        );

        /* Truncate all the data before populating*/
        if (DB::table('permissions')->get()->count() > 0) {
            DB::table('permissions')->truncate();
        }

        DB::table('permissions')->insert($data);
    }
}
