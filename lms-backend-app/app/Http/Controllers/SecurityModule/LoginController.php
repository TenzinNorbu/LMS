<?php

namespace App\Http\Controllers\SecurityModule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Illuminate\Http\Requests\ClientRequest;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use Session;
use Carbon\Carbon; 
use DB;
use Auth;
use Illuminate\Support\Facades\Crypt;


class LoginController extends Controller
{
    public function authenticate(Request  $request)
    {
        $request->validate([
            'user_id' => 'required|string',
            'password' => 'required|string',
        ]);
             
        $user = $request->only('user_id','password');
         if (!$token = JWTAuth::attempt($user)) {
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
    
    public function logout()
    {
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

    public function refreshToken()
    {
        return $this->createToken(auth()->refresh());
    }


    protected function createToken($token)
    {
        DB::table('personal_access_tokens')->insert([
            'tokenable'=> 'JWT',
            'name' =>auth()->user()->user_id,
            'token' =>$token
          ]);
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'payload' => auth()->user(),
        ]);
    }
}
