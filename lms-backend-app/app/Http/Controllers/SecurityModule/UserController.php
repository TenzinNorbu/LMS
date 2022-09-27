<?php

namespace App\Http\Controllers\SecurityModule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use DB;
//use Illuminate\Support\Arr;
//use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Auth;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['user']]);
    }

    public function index()
    {
       $users = User::all();
        return response()->json([
            'status' => 'success',
            'user' => $users,
        ]);
        }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'cid' => 'required|string|min:11|max:11',
            'gender' => 'required|string',
            'contactNo' => 'required|integer',
            'roles' => 'required|string',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ]);
        
        if(!($validator->fails())) {
            $user = new User;
            $user->cid = $request->cid;
            $user->name = $request->name;
            $user->gender = $request->gender;
            $user->contactNo = $request->contactNo;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->assignRole($request->input('roles'));
            $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User successfully Registered',
            'user' => $user,
            ]);
        }
        else{
            return response()->json([
                'errors'=>$validator->errors()->all(),
                'message' => 'User Registration Failed'
            ],401);
        }
    }

    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'User not Found',
        ]);
    }
    return response()->json([
        'status' => 'success',
        'user' => $user,
       ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'cid' => 'required|string|min:11|max:11',
            'gender' => 'required|string',
            'contactNo' => 'required|integer',
            'roles' => 'required|string',
        ]);

        $user = User::find($id);
        $user->cid = $request->cid;
        $user->name = $request->name;
        $user->gender = $request->gender;
        $user->contactNo = $request->contactNo;
        //$user->save();

        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->input('roles'));
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully',
            'user' => $user,
        ]);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully',
            'user' => $user,
        ]);
    }
}
