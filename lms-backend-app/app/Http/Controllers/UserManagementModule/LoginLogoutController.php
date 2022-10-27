<?php

namespace App\Http\Controllers\UserManagementModule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserManagement\LoginRequest;
use App\Http\Traits\UserManagement\LoginLogoutTrait;

class LoginLogoutController extends Controller
{
    use LoginLogoutTrait;

    public function authenticate(LoginRequest $request){
        return $this->login($request);
    }
    
    public function refreshToken()
    {
        return $this->createToken(auth()->refresh());
    }
    public function logout(){
          return $this->userLogout();
      }
}
