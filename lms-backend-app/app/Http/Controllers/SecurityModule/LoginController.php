<?php

namespace App\Http\Controllers\SecurityModule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Carbon\Carbon; 
use DB;
use Auth;


class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $request->validate([
            'user_id' => 'required|string',
            'password' => 'required|string',
        ]);
        $user = $request->only('user_id','password');
            try{
                if (!$token = JWTAuth::attempt($user)) {
                    return response()->json([
                       'status' => 'error',
                        'message' => 'Invalid Credentials or User not found'
                    ], 401);
                }
            } catch (JWTException $e) {
                return response()->json([
                    'error' => 'Could not create token'
                ], 500);
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

    protected function createToken($token){

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'payload' => auth()->user(),
        ]);
    }
}
