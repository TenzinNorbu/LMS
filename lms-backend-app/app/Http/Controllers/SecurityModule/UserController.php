<?php

namespace App\Http\Controllers\SecurityModule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Branch;
use App\Models\Department;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon; 
//use Spatie\Permission\Models\Role;
use DB;

class UserController extends Controller
{
    public function index()
    {
       $users = User::all();
       return $this->sendResponse($users,'Users Details');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_full_name' => 'required|string',
            'employment_id' => 'required|string',
            'branch_id' => 'required|string',
            'department_id' => 'required|string',
            'designation' => 'required|string',
            'phone_no' => 'required',
            'email' => 'required|string|email|max:100|unique:users',
            'user_id' => 'required|string',
            'password' => 'required|confirmed|min:6',
        ]);
        
        if(($validator->fails())) {

            $user = new User;
            $user->employee_full_name = $request->employee_full_name;
            $user->employment_id = $request->employment_id;
            $user->branch_id = $request->branch_id;
            $user->department_id = $request->department_id;
            $user->email= $request->email;
            $user->designation= $request->designation;
            $user->phone_no = $request->phone_no;
            $user->user_id =$request->user_id;
            $user->password = Hash::make($request->password);

            DB::table('user_log_managements')->insert([
                'user_id' => $request->user_id, 
                'register_date' => Carbon::now()
              ]);
            $user->save();

        return $this->sendResponse($user,'User Created Successfully!',201);
        }
    }

    public function show($id)
    {
        $user = User::find($id);
        return $user ? $this->sendResponse($user, 'User Detail retrieved Successfully!', 200) 
        : $this->sendError('User not found.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'employee_full_name' => 'required|string',
            'employment_id' => 'required|string',
            'branch_id' => 'required|string',
            'department_id' => 'required|string',
            'phone_no' => 'required|string',
            'designation' => 'required|string',
            'user_id' => 'required|string',
            'email' => 'required|string',
            'user_status' => 'required|string',
        ]);

        $user = User::find($id);
        $user->employee_full_name = $request->employee_full_name;
        $user->employment_id = $request->employment_id;
        $user->branch_id = $request->branch_id;
        $user->department_id = $request->department_id;
        $user->phone_no = $request->phone_no;
        $user->designation = $request->designation;
        $user->user_id = $request->user_id;
        $user->email = $request->email;
        $user->user_status = $request->user_status;

        // DB::table('model_has_roles')->where('model_id',$id)->delete();
        // $user->assignRole($request->input('roles'));
        $user->save();

        return $user ? $this->sendResponse($user, 'User updated Successfully!', 200) 
        : $this->sendError('User not found.');

    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return $branch ? $this->sendResponse($branch, 'User deleted Successfully!', 200) 
        : $this->sendError('User not found.');
    }

    
}
