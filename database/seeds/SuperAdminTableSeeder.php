<?php

use Illuminate\Database\Seeder;

class SuperAdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employee = factory(\App\Employee\Models\MasterEmployee::class)->create(); //create employee
        $employee->user()->save(factory(\App\Account\Models\User::class)->make()); //save user

        //give all permissions and all roles
        $user = \App\Account\Models\User::where('employeeId',$employee->id)->first();
        if($user){

            //give all permissions
            $permissions = \Spatie\Permission\Models\Permission::all();
            foreach ($permissions as $permission){
                $user->givePermissionTo($permission->name);
            }

            //give all roles
            $roles = \Spatie\Permission\Models\Role::all();
            foreach ($roles as $role){
                $user->assignRole($role->name);
            }

        }

    }
}
