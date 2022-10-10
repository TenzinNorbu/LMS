<?php

namespace App\Http\Controllers\SecurityModule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon; 
use Mail; 
use Illuminate\Support\Str;
use Auth;
use DB;

class ChangeAndForgotPasswordController extends Controller
{
    //forgot password
    public function sendResetLinkEmail(Request $request)
    {
        dd('test');
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
          ]);

        Mail::send('email.forgetPassword', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return response()->json(['message', 'We have e-mailed your password reset link!']);
    }

    public function passwordReset(Request $request)
      {
          $request->validate([
              'email' => 'required|email|exists:users',
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);
  
          $updatePassword = DB::table('password_resets')
                              ->where([
                                'email' => $request->email, 
                                'token' => $request->token
                              ])
                              ->first();
  
          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }
  
          $user = User::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);
 
          DB::table('password_resets')->where(['email'=> $request->email])->delete();
  
          return response()->json(['message', 'Your password has been changed!']);
      }


    //change password

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

        DB::table('user_log_managements')->insert([
            'user_id' =>auth()->user()->user_id, 
            'password_change_date' => Carbon::now()
          ]);
        $user->save();
        return $this->sendResponse($user,'Password changed successfully.');
    }

}
