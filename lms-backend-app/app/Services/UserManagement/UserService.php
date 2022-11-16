<?php

namespace App\Services\UserManagement;

use App\Repositories\UserManagement\UserRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests\UserManagement\StoreUserRequest;
use DB;

class UserService{
    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function saveUserData(StoreUserRequest $userDetails){
        $validated = $userDetails->validated();
        return $validated ? $this->userRepository->save($userDetails):$this->sendError('Validation Fail');
    }
    
    public function getAll(){
        return $this->userRepository->getAllUsers();
    }

    public function getById($userId){
        return $this->userRepository->getUserById($userId);
    }

    public function userUpdate(Request $userDetails, $userId){
        $validator = Validator::make($userDetails->all(), [
            'employment_id' => 'required|string',
            'branch_id' => 'required|string',
            'department_id' => 'required|string',
            'phone_no' => 'required|string',
            'designation' => 'required|string',
            'user_id' => 'required|string',
            'email' => 'required|string',
            'user_status' => 'required|string',
        ]);
        return $this->userRepository->updateUser($userId,$userDetails);
    }

    public function deleteUser($userId){
        return $this->userRepository->deleteUser($userId);
    }
}