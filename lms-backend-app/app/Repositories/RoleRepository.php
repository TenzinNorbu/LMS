<?php

namespace App\Repositories;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleRepository{
    public function getRole(){
      return Role::all();
    }

    public function createRole(Request $request){
        $role=Role::create($request->all());
        return $role->syncPermissions($request->input('permission'));
    }

    public function showRole($roleId){
        $role = Role::find($roleId);
        return $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$roleId)
            ->get();
    }

    public function updateRole(Request $roleId){
        $role = Role::find($roleId);
        $role->name = $request->input('name');
        $role->save();
        return $role->syncPermissions($request->input('permission'));
    }

    public function deleteRole($roleId){
        return Role::find($roleId)->delete();       
    }
}