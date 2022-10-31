<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;
use App\Http\Requests\UserManagement\StoreUserRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class UserService{
    private $userRepository;

    public function __construct(UserRepository $userRepository) 
    {
        $this->userRepository = $userRepository;
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
}