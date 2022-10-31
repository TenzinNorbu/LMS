<?php
namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Auth;
use DB;

class ChangeForgotPasswordRepository{ 
    public function passwordLink($request){
        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $request->email, 
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        $details = [
            'email'=> $request->email,
            'url' => env('APP_URL').("/api/reset-password/$token")
        ];
            Mail::send('forgetPassword',$details, function($message) use($request){
            $message->from('tnorbu2424@gmail.com','BIL LMS System');
            $message->to($request->email);
            $message->subject('Reset Your BIL LMS Account Password');
        });
        return response()->json([
            'status' => 'success',
            'message' => 'We have e-mailed your password reset link. Please reset your password!']);

        }

    public function passwordReset($request){
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

    public function passwordChange($id){
        $user = User::find($id);
        $user->password = Hash::make($request->new_password);

        DB::table('user_log_managements')->insert([
            'user_id' =>auth()->user()->user_id, 
            'password_change_date' => Carbon::now()
          ]);
        $user->save();
        return response()->json([
            'status'=> 'success',
            'message' => 'Your password changed successfully']);
    }
}
