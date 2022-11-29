<?php

namespace App\Services\UserManagement;

use App\Repositories\UserManagement\ChangeForgotPasswordRepository;
use App\Http\Requests\UserManagement\ResetPasswordRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use ESolution\DBEncryption\Encrypter;

class ChangeForgotPasswordService{
    public function __construct(ChangeForgotPasswordRepository $changeForgotPasswordRepository) {
        $this->changeForgotPasswordRepository = $changeForgotPasswordRepository;
    }

    public function resetLink($request){
        $user = User::where('email', 'LIKE', '%' . Encrypter::encrypt($request->email))->exists();
        return $user ? $this->changeForgotPasswordRepository->passwordLink($request) 
        : response()->json([
            'status' => 'error',
            'message' => 'Your request email not found in the list.Please check your email Id!'
            ]);
    }

    public function reset($request, $token){
        $updatePassword = DB::table('password_resets')->where([
                    'email' => $request->email, 
                    'token' => $request->token])->exists();
        return $updatePassword ? $this->changeForgotPasswordRepository->passwordReset($request) : response()->json([
                'status'=> 'error',
                'message' => 'Invalid Token Id!']);
          }

    public function updatePassword($request, $id){
        $password=Hash::check($request->old_password, auth()->user()->password);
        return $password ? $this->changeForgotPasswordRepository->passwordChange($request, $id) :$this->sendError('Old password doesnot match.');
    }
}