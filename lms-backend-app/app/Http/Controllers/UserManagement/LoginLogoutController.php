<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserManagement\LoginLogoutService;
use App\Http\Requests\UserManagement\LoginRequest;

class LoginLogoutController extends Controller
{
    public function __construct(LoginLogoutService $loginLogoutService) {
        $this->loginLogoutService = $loginLogoutService;
    }
    
    public function authenticate(LoginRequest $request){
        return $this->loginLogoutService->userLogin($request);
    }

    public function refreshToken(){
        return $this->createToken(auth()->refresh());
    }

    public function logout(){
        return $this->loginLogoutService->userLogout();
    }
}

