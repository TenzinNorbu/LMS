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

    public function updateUser($userId, $userDetails){

        $user = User::find($userId);
        $user->employment_id = $userDetails->employment_id;
        $user->branch_id = $userDetails->branch_id;
        $user->department_id = $userDetails->department_id;
        $user->phone_no = $userDetails->phone_no;
        $user->designation = $userDetails->designation;
        $user->user_id = $userDetails->user_id;
        $user->email = $userDetails->email;
        $user->user_status = $userDetails->user_status;
        $user->save();
        return $user;
    }
    public function deleteUser($userId){
        return User::destroy($userId);
    }
}