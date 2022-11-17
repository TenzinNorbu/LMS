<?php

namespace App\Services\UserManagement;

use App\Repositories\UserManagement\RoleRepository;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserManagement\StoreRoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleService{
    public function __construct(RoleRepository $roleRepository){
        $this->roleRepository = $roleRepository;
    }

    public function createRole(StoreRoleRequest $role){
        $validated = $role->validated();
        return $validated ? $this->roleRepository->saveRole($role):$this->sendError('Validation Fail');
    }

    public function getRole(){
        return $this->roleRepository->getRole();
    }

    public function showRole($roleId){
        return $this->roleRepository->showRole($roleId);
    }

    public function updateRole(Request $role,$roleId){
        $validated = validator::make($role,[
            'name' => 'required',
            'permission' => 'required'
        ]);
        if($validated->fails()){
            return "Validation fails";
        }else{
            return $this->roleRepository->updateRole($role, $roleId);
        }
    }

    public function deleteRole($roleId){
        return $this->roleRepository->deleteRole($roleId);
    }
}