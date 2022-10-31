<?php

namespace App\Repositories;
use App\Models\User;
use DB;
use Carbon\Carbon;
use Session;

class LoginLogoutRepository{

    public function logout(){

        $currentUser=auth()->user()->user_id;
        Session::flush();
        auth()->logout();
        DB::table('user_log_managements')->insert([
            'user_id' =>$currentUser, 
            'logout_date' => Carbon::now()
          ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }
}
