<?php

namespace App\Http\Controllers\SecurityModule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Branch;
use App\Models\Department;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

use Auth;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['user']]);
    }

    public function index()
    {
        // $users = User::select([
        //     //'users.*',
        //     'users.cid_no'
        //      => Crypt::decryptString('cid_no') 
        //     //Post::selectRaw('MAX(created_at)')
        //     //        ->whereColumn('user_id', 'users.id')
        // ])->get();
       $users = User::all();
      // try {
       //$user = decrypt($users->cid_no);
       return $this->sendResponse($users,'Users Details');

    // } catch (DecryptException $e) {
        //
     //}
      // $user = Crypt::decryptString($users->cid_no);
        // return $this->sendResponse($user,'Users Details');
        }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'cid_no' => 'required|string|min:11|max:11',
            'gender' => 'required|string',
            'emp_id' => 'required|string',
            'branch_id' => 'required|integer',
            'department_id' => 'required|integer',
            'contact_no' => 'required',
            'roles' => 'required|string',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ]);
        
        if(!($validator->fails())) {
            $user = new User;
            $user->cid_no =Crypt::encryptString($request->cid_no);
            $user->name = Crypt::encryptString($request->name);
            $user->emp_id = $request->emp_id;
            $user->gender = $request->gender;
            $user->branch_id = $request->branch_id;
            $user->department_id = $request->department_id;
            $user->contact_no =Crypt::encryptString($request->contact_no);
            $user->email = Crypt::encryptString($request->email);
            $user->password = Hash::make($request->password);
            $user->assignRole($request->input('roles'));
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
            'name' => 'required|string|between:2,100',
            'cid_no' => 'required|string|min:11|max:11',
            'emp_id' => 'required|string',
            'gender' => 'required|string',
            'branch_id' => 'required|string',
            'department_id' => 'required|string',
            'contact_no' => 'required|integer',
            'roles' => 'required|string',
        ]);

        $user = User::find($id);
        $user->cid_no =Crypt::encryptString($request->cid_no);
        $user->name = Crypt::encryptString($request->name);
        $user->gender = $request->gender;
        $user->emp_id = $request->emp_id;
        $user->contact_no =Crypt::encryptString($request->contact_no);
        $user->branch_id = $request->branch_id;
        $user->department_id = $request->department_id;
        //$user->save();

        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->input('roles'));
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
