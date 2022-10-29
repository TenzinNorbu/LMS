<?php

namespace App\Repositories;
use App\Models\User;
use DB;
use Carbon\Carbon;

class UserRepository{
    public function getAllUsers(){
        return User::all();
    }

    public function register($userDetails){
        $user = User::create($userDetails->all());

        DB::table('user_log_managements')->insert([
            'user_id' => $userDetails->user_id, 
            'register_date' => Carbon::now()
        ]);
        return $user;
    }

    public function getUserById($userId){
        return User::find($userId);
    }

    public function updateUser($userDetails, $userId){
        return User::whereId($userId)->update($UserDetails);

        
    // $user = User::find($id);
    // $user->employee_full_name = $request->employee_full_name;
    // $user->employment_id = $request->employment_id;
    // $user->branch_id = $request->branch_id;
    // $user->department_id = $request->department_id;
    // $user->phone_no = $request->phone_no;
    // $user->designation = $request->designation;
    // $user->user_id = $request->user_id;
    // $user->email = $request->email;
    // $user->user_status = $request->user_status;
    // $user->save();
    }
    public function deleteUser($userId){
        return User::destroy($userId);
    }
}