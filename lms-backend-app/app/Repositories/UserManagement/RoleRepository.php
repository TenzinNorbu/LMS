<?php

namespace App\Repositories\UserManagement;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleRepository{
    public function __construct(Role $role){
        $this->role = $role;
    }

    public function saveRole(Request $request){
        $role=$this->role->create($request->all());
        return $role->syncPermissions($request->input('permission'));
    }

    public function getRole(){
        return $this->role->get();
    }


    public function showRole($roleId){
        $role =$this->role->find($roleId);
        return $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$roleId)->get();
    }

    public function updateRole($role, $roleId){
        $role =$this->role->find($roleId);
        $role->name = $role->input('name');
        $role->save();
        return $role->syncPermissions($role->input('permission'));
    }

    public function deleteRole($roleId){
        return $this->role->destroy($roleId);       
    }
}