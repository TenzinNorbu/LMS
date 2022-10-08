<?php

namespace App\Http\Controllers\SecurityModule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;

class ChangeAndForgotPasswordController extends Controller
{
    public function updatePassword(Request $request, $id)
     {
        # Validation
        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        // #Match The Old Password
        if(!Hash::check($request->old_password, auth()->user()->password)){
        return $this->sendError('Old Password Doesnt Match.');
        }
        #Update the new Password
        $user = User::find($id);
        $user->password = Hash::make($request->new_password);
        $user->save();
        return $this->sendResponse($user,'Password changed successfully.');
}
}
