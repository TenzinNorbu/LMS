<?php
namespace App\Repositories\UserManagement;
use Illuminate\Http\Request;
use App\Http\Requests\UserManagement\ResetPasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use ESolution\DBEncryption\Encrypter;

class ChangeForgotPasswordRepository{ 
    public function passwordLink($request){
        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $request->email, 
            'token' => $token,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $details = [
            'email'=> $request->email,
            'url' => env('APP_URL').("/api/reset-password/$token")
        ];
            Mail::send('forgetPassword',$details, function($message) use($request){
            $message->from('tnorbu2424@gmail.com','BIL-LMS-System');
            $message->to($request->email);
            $message->subject('Reset Your BIL LMS Account Password');
        });
        return response()->json([
            'status' => 'success',
            'message' => 'We have e-mailed your password reset link. Please reset your password!']);
        }

    public function passwordReset($request){
        $user_name = User::select('user_name','password')->where('email', 'LIKE', '%' . Encrypter::encrypt($request->email))->first();
        if(!Hash::check($request->password,'$user_name->password')){
            DB::table('users')->where('email', 'LIKE', '%' . Encrypter::encrypt($request->email))->update([
                'password' => Hash::make($request->password),
                'password_created_date'=> Carbon::now()->format('Y-m-d'),
                'password_reset_date'=> Carbon::now()->addDays(45)]);

            DB::table('user_log_managements')->insert([
                    'user_name' => $user_name, 
                    'password_change_date' => Carbon::now()->format('Y-m-d H:i:s')]);
                    
            DB::table('password_resets')->where(['email'=> $request->email])->delete();
    
            return response()->json([
                'status'=> 'success',
                'message' => 'Your password has been changed!']);
            }else{
                return response()->json([
                    'status'=> 'error',
                    'message' => 'You are not allow to use the same password time and again.Please create different password!']);
            }
    }

    public function passwordChange(Request $request){
       $user = User::where('id','=',$request->id)->first();
        if(!Hash::check($request->new_password, $user->password)){
            User::whereId(auth()->user()->id)->update([
                'password' => Hash::make($request->new_password),
                'password_created_date'=> Carbon::now()->format('Y-m-d'),
                'password_reset_date'=> Carbon::now()->addDays(45),
            ]);
    
            DB::table('user_log_managements')->insert([
                'user_name' =>auth()->user()->user_name, 
                'password_change_date' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
            return response()->json([
                'status'=> 'success',
                'message' => 'Your password changed successfully']);
            }else{
                return response()->json([
                    'status'=> 'error',
                    'message' => 'You are not allow to use the same password time and again.Please create different password!']);
            }
        }
}
