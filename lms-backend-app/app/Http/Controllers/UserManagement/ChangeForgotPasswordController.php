<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserManagement\ForgotPasswordRequest;
use App\Http\Requests\UserManagement\ResetPasswordRequest;
use App\Http\Requests\UserManagement\ChangePasswordRequest;
use App\Services\UserManagement\ChangeForgotPasswordService;


class ChangeForgotPasswordController extends Controller{
    private $changeForgotPasswordService;

    public function __construct(ChangeForgotPasswordService $changeForgotPasswordService){
        $this->changeForgotPasswordService= $changeForgotPasswordService;
    }

    public function resetEmailLink(ForgotPasswordRequest $request){
        return $this->changeForgotPasswordService->resetLink($request);
    }

    public function passwordResetLink(ResetPasswordRequest $request, $token){
        return $this->changeForgotPasswordService->reset($request, $token);
    }

    public function changePassword(ChangePasswordRequest $request){
         return $this->changeForgotPasswordService->updatePassword($request, $request->id);
     }
}
