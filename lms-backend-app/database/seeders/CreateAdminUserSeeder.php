<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Crypt;



class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'employee_full_name' => 'LMS-ADMIN', 
            'employment_id'=> 'BIL/123',
            'phone_no'=>'12345678',
            'branch_id' =>'1',
            'department_id'=>'3',
            'designation'=>'PMU',
            'email_id' => 'lms-admin@gmail.com',
            'user_id' => 'LMS_ADMIN',
            'password' => bcrypt('lms@1234'),
            'confirm_password' => bcrypt('lms@1234')
        ]);
      
        $role = Role::create(['name' => 'Super Admin']);

        $permissions = Permission::pluck('id','id')->all();
     
        $role->syncPermissions($permissions);
       
        $user->assignRole([$role->id]);
    }
 }

