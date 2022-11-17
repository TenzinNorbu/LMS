<?php

namespace App\Repositories\UserManagement;
use App\Models\User;
use DB;
use Carbon\Carbon;
use ESolution\DBEncryption\Encrypter;

class UserRepository{
    public function __construct(User $user){
        $this->user = $user;
    }

    public function save($userDetails){
        $user = User::create($userDetails->all());
        DB::table('user_log_managements')->insert([
            'user_id' => $userDetails->user_id, 
            'register_date' => Carbon::now()
        ]);
        return $user;
    }

    public function getAllUsers(){
        $data = DB::table('users')->select('employee_full_name', 'branch_id','user_id')->get();
        $data->transform(function($user) {
            $user->employee_full_name = Encrypter::decrypt($user->employee_full_name);
            $user->branch_id = Encrypter::decrypt($user->branch_id);
        return  $user;
            });
        return $data;
    }


    public function getUserById($userId){
        return User::find($userId);
    }

    public function updateUser($userId, $userDetails){

        $user = User::find($userId);
        return $user;
        
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