<?php

namespace App\Services;

use App\Repositories\LoginLogoutRepository;
use Illuminate\Http\Request;
use App\Models\User;
use JWTAuth;
use DB;
use Session;
use Carbon\Carbon;

class LoginLogoutService {
    public function userLogin($request) {
        
        $user=$request->only('user_id','password');
        
        if(!$token=JWTAuth::attempt($user)) {
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