<?php

namespace App\Http\Controllers\UserManagementModule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserManagement\ForgotPasswordRequest;
use App\Http\Requests\UserManagement\ResetPasswordRequest;
use App\Http\Requests\UserManagement\ChangePasswordRequest;
use App\Http\Traits\UserManagement\ChangeForgotPasswordTrait;


class ChangeForgotPasswordController extends Controller
{
    use ChangeForgotPasswordTrait;

    public function resetEmailLink(ForgotPasswordRequest $request)
    {
        return $this->resetLinkEmail($request);
    }

    public function passwordResetLink(ResetPasswordRequest $request, $token)
    {
        return $this->passwordReset($request, $token);
    }

    public function changePassword(ChangePasswordRequest $request, $id)
     {
         return $this->updatePassword($request, $id);
     }
}
