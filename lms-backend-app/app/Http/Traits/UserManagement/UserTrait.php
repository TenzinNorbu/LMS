<?php

namespace App\Http\Traits\UserManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Session;
use Carbon\Carbon;

trait UserTrait {

    public function getUser() {
        $users = User::all();
        return $users ? $this->sendResponse($users, 'User Detail retrieved Successfully!',200) 
        : $this->sendError('User not found');
    }
    public function register($request)
    {
        $user = User::create($request->all());
        DB::table('user_log_managements')->insert([
            'user_id' => $request->user_id, 
            'register_date' => Carbon::now()
        ]);
    
        return $user ? $this->sendResponse($user, 'User created Successfully!',201) 
        : $this->sendError('User creation error');
    }

    public function showUser($id)
    {
        $user= User::find($id);
        return $user ? $this->sendResponse($user, 'User Detail retrieved Successfully!',200) 
        : $this->sendError('User not found');
    }

    public function updateUser($request, $id)
    {
        $user = User::find($id);
        $user->employee_full_name = $request->employee_full_name;
        $user->employment_id = $request->employment_id;
        $user->branch_id = $request->branch_id;
        $user->department_id = $request->department_id;
        $user->phone_no = $request->phone_no;
        $user->designation = $request->designation;
        $user->user_id = $request->user_id;
        $user->email = $request->email;
        $user->user_status = $request->user_status;

        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->input('roles'));

        $user->save();
        return $user ? $this->sendResponse($user,'User Updated Successfully!!', 200)
         : $this->sendError('User not able to update.');
    }

    public function deleteUser($id)
    { 
        $user = User::find($id)->delete();
        return $user ? $this->sendResponse($user, 'User Deleted Successfully!!',200) 
        : $this->sendError('User not found');
    }
}