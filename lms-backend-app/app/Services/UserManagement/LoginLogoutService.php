<?php

namespace App\Services\UserManagement;

use Illuminate\Http\Request;
use App\Http\Requests\UserManagement\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use JWTAuth;
use Session;
use Carbon\Carbon;
use ESolution\DBEncryption\Encrypter;


class LoginLogoutService{
    public function userLogin(LoginRequest $request){
        $user_name = User::where('user_name', 'LIKE', '%' . Encrypter::encrypt($request->user_name))->get()->first();

        if(!$user_name){
           return response()->json(['success'=>false, 'message' => 'Login Fail, please check your user name']);}
            if(!Hash::check($request['password'], $user_name->password)){
              return response()->json(['success'=>false, 'message' => 'Login Fail, please check your password']);}
                if(!$token=JWTAuth::fromUser($user_name)){
                    return response()->json(['success'=>false, 'message' => 'Token Fail, please check token generation']); 
        }
        DB::table('user_log_managements')->insert([
            'user_name' =>$request->user_name,
            'login_date' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60,
                'data' => $user_name,
            ]);
    }

    public function userLogout(){
        $currentUser=auth()->user()->user_name;
        Session::flush();
        auth()->logout();
        DB::table('user_log_managements')->insert([
            'user_name' =>$currentUser, 
            'logout_date' => Carbon::now()->format('Y-m-d H:i:s'),
          ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }
}