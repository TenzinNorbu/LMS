<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use App\Services\UserManagement\UserService;
use Illuminate\Http\Request;
use App\Http\Requests\UserManagement\StoreUserRequest;

class UserController extends Controller
{
    public function __construct(UserService $userService) 
    {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=$this->userService->getAll();
        return $users ? $this->sendResponse($users, 'User Detail retrieved Successfully!',200) 
        : $this->sendError('User not found');
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
    public function store(StoreUserRequest $userDetails)
    {
        $user= $this->userService->saveUserData($userDetails);
        return $user ? $this->sendResponse($user, 'User Submitted Successfully!',200) 
        : $this->sendError('User not found');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($userId)
    {
        $user= $this->userService->getById($userId);
        return $user ? $this->sendResponse($user, 'User Retrived Successfully!',200) 
        : $this->sendError('User not found');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $userId, $userDetails)
    {
         $user= $this->userService->userUpdate($userId, $userDetails);
         return $user ? $this->sendResponse($user, 'User Updated Successfully!!',200) 
         : $this->sendError('User not found');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId)
    {
        $user=$this->userService->deleteUser($userId);
        return $user ? $this->sendResponse($user, 'User Deleted Successfully!!',200) 
        : $this->sendError('User not found');

    }
}
