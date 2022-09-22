<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


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
            'cid' => '10603002424',
            'name' => 'tenzin', 
            'gender'=> 'M',
            'contactNo'=>'17439160',
            'email' => 'admin2@gmail.com',
            'password' => bcrypt('123456')
        ]);
      
        $role = Role::create(['name' => 'User']);
       
        $permissions = Permission::pluck('id','id')->all();
     
        $role->syncPermissions($permissions);
       
        $user->assignRole([$role->id]);
    }
 }

