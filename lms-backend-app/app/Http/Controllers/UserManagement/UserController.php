<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use App\Services\UserManagement\UserService;
use Illuminate\Http\Request;
use App\Http\Requests\UserManagement\StoreUserRequest;
use App\Http\Requests\UserManagement\UserUpdateRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use App\Models\User;


class UserController extends Controller{
    public function __construct(UserService $userService){
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $users=$this->userService->getAll();
        return $users ? $this->sendResponse($users, 'User Detail retrieved Successfully!',200) : $this->sendError('User not found');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $userDetails){
        $user= $this->userService->saveUserData($userDetails);
        return $user ? $this->sendResponse($user, 'User Submitted Successfully!',200) : $this->sendError('User not found');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($userId){
        $user= $this->userService->getById($userId);
        return $user ? $this->sendResponse($user, 'User Retrived Successfully!',200) : $this->sendError('User not found');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($userId){
        $user=User::find($userId);
        $roles=Role::all();
        $permissions=Permission::all();
        $user_permissions = $user->getAllPermissions();

        $user_roles=$this->userService->getUserRole($userId);
        
        return response()->json([
            'status'=>'true',
            'message'=> 'User-Role-Permission Details',
            'user-data' => $user, 'user-role' => $user_roles,'user-permissions' => $user_permissions, 'roles' => $roles,'permission' => $permissions
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $userDetails, $userId){
        $user= $this->userService->userUpdate($userDetails,$userId);
        return $user ? $this->sendResponse($user, 'User Updated Successfully!!',200): $this->sendError('User updation fail');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId){
        $user=$this->userService->deleteUser($userId);
        return $user ? $this->sendResponse($user, 'User Deleted Successfully!!',200) : $this->sendError('User not found');
    }
}
