<?php

namespace App\Services\UserManagement;

use App\Repositories\UserManagement\UserRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests\UserManagement\StoreUserRequest;
use App\Http\Requests\UserManagement\UserUpdateRequest;
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
        $validated = validator::make($userDetails,[
            'employee_full_name' => 'required',
            'employment_id' => 'required',
            'branch_id' => 'required',
            'department_id' => 'required',
            'designation' => 'required',
            'phone_no' => 'required',
            'user_id' => 'required',
            'user_status' => 'required'
        ]);
        return $validated;
        $validated = $userDetails->safe()->only(['employment_id', 'branch_id','department_id','phone_no','designation','user_id','email','user_status']);
        return $validated ? $this->userRepository->updateUser($userId,$userDetails):$this->sendError('Validation Fail');
    }

    public function deleteUser($userId){
        return $this->userRepository->deleteUser($userId);
    }
}