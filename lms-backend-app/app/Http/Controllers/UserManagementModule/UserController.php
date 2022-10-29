<?php

namespace App\Http\Controllers\UserManagementModule;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Requests\UserManagement\StoreUserRequest;


class UserController extends Controller
{
    private $userRepository,$userService;

    public function __construct(UserService $userService, UserRepository $userRepository) 
    {
        $this->userService = $userService;
        $this->userRepository=$userRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=$this->userRepository->getAllUsers();
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
        $user= $this->userRepository->register($userDetails);
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
        $user= $this->userRepository->getUserById($userId);
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
    public function update(Request $userDetails, $userId)
    {
         $user= $this->userService->updateUser($userDetails, $userId);
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
        $user=$this->userRepository->deleteUser($userId);
        return $user ? $this->sendResponse($user, 'User Deleted Successfully!!',200) 
        : $this->sendError('User not found');

    }
}
