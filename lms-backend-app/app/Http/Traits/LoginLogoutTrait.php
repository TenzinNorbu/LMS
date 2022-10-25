<?php

namespace App\Http\Traits;
use Illuminate\Http\Request;
use App\Models\User;
use JWTAuth;
use Carbon\Carbon; 
use DB;
use Session;

trait LoginLogoutTrait {

    public function login($request) {
        $user=$request->only('user_id','password');

        if (!$token=JWTAuth::attempt($user)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Credentials or User not found'
                ], 401);
           }
       DB::table('user_log_managements')->insert([
           'user_id' =>auth()->user()->user_id, 
           'login_date' => Carbon::now()
         ]);
       return $this->createToken($token);
    }


    public function userLogout()
    {
        //return "test";
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

    protected function createToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'payload' => auth()->user(),
        ]);
    }
}