<?php

namespace App\Http\Controllers\SecurityModule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Traits\LoginLogoutTrait;

class LoginLogoutController extends Controller
{
    use LoginLogoutTrait;

    public function authenticate(LoginRequest $request){
        return $this->login($request);
    }

    public function logout(){
          return $this->userLogout();
      }
}
