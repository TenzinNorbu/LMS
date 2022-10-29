<?php

namespace App\Http\Traits\UserManagement;
use Illuminate\Http\Request;
use App\Models\User;
use App\Classes\ModelDecrypter;
use Spatie\Permission\Models\Role;
use DB;
use Carbon\Carbon;

trait UserTrait {

    public function getUser() {
        $users = User::all();
        //  $users=DB::table('users')->get();
        //  $clientData = (new ModelDecrypter)->decryptCollection($users);

        // return $clientData;

        return $users ? $this->sendResponse($users, 'User Detail retrieved Successfully!',200) 
        : $this->sendError('User not found');
    }
    public function register($request)
    {
        $user = User::create($request->all());
        DB::table('user_log_managements')->insert([
            'user_id' => $request->user_id, 
            'register_date' => Carbon::now()
        ]);
        return $user ? $this->sendResponse($user, 'User created Successfully!',201) 
        : $this->sendError('User creation error');
    }

    public function showUser($id)
    {
        $user= User::find($id);
        return $user ? $this->sendResponse($user, 'User Detail retrieved Successfully!',200) 
        : $this->sendError('User not found');
    }

    public function updateUser($request, $id)
    {
        $input = $request->all();
        $user = User::find($id);
        $user->update($input);
        
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->input('roles'));

        return $user ? $this->sendResponse($user,'User Updated Successfully!!', 200)
         : $this->sendError('User not able to update.');
    }

    public function deleteUser($id)
    { 
        $user = User::find($id)->delete();
        return $user ? $this->sendResponse($user, 'User Deleted Successfully!!',200) 
        : $this->sendError('User not found');
    }
}