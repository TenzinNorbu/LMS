<?php

namespace App\Http\Controllers\SecurityModule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Auth;
use DB;

class ChangeAndForgotPasswordController extends Controller
{
    //forgot password
public function resetLinkEmail(Request $request)
    {
        $request->validate([
           'email' => 'required|email',
        ]);
        $user=User::where('email','=', $request->email)->exists();
       if($user){
        
        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
          ]);

        //Mail::send('email.forgetPassword', ['token' => $token], function($message) use($request){
            Mail::to(['token' => $token], function($message) use($request){
            $message->from('tnorbu2424@gmail.com','test');
            $message->to($request->email);
            $message->subject('Reset Password');
        });
        return response()->json([
            'status' => 'success',
            'message' => 'We have e-mailed your password reset link!']);
      
    }else{

        return response()->json([
            'status' => 'error',
            'message' => 'Your request email not found in the list.Please check your email Id!']);
    }

}

    public function passwordReset(Request $request)
      {
          $request->validate([
              'email' => 'required|email',
             // 'password' => 'required|string|min:6|confirmed',
              'password' => 'required',
             //'password_confirmation' => 'required'
          ]);

          $updatePassword = DB::table('password_resets')
                              ->where([
                                'email' => $request->email, 
                                'token' => $request->token
                              ])->exists();

          if(!$updatePassword){
            return response()->json([
                'status'=> 'error',
                'message' => 'Invalid email id or Token!']);
          }
        $user_id=User::select('user_id')
                     ->where('email', '=', $request->email)->get();

        DB::table('users')->where('email','=',$request->email)
                         ->update(['password' => Hash::make($request->password)]);

        DB::table('user_log_managements')->insert([
                 'user_id' => $user_id, 
                 'password_change_date' => Carbon::now()
        ]);

        DB::table('password_resets')->where(['email'=> $request->email])->delete();
  
        return response()->json([
              'status'=> 'success',
              'message' => 'Your password has been changed!']);
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
