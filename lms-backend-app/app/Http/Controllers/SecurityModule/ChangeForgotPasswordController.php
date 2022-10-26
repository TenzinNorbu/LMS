<?php

namespace App\Http\Controllers\SecurityModule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Traits\ChangeForgotPasswordTrait;


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
