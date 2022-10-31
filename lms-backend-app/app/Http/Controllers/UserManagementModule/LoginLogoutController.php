<?php

namespace App\Http\Controllers\UserManagementModule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\LoginLogoutService;
use App\Repositories\LoginLogoutRepository;
use App\Http\Requests\UserManagement\LoginRequest;

class LoginLogoutController extends Controller
{
      private $loginLogoutRepository, $loginLogoutService;

      public function __construct(LoginLogoutService $loginLogoutService, LoginLogoutRepository $loginLogoutRepository) 
      {
          $this->loginLogoutService = $loginLogoutService;
          $this->loginLogoutRepository=$loginLogoutRepository;
      }
    
      public function authenticate(LoginRequest $request){
          return $this->loginLogoutService->userLogin($request);
      }

      public function refreshToken()
    {
        return $this->createToken(auth()->refresh());
    }
    public function logout(){
          return $this->loginLogoutRepository->logout();
      }
}
