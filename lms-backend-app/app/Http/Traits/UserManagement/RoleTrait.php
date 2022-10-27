<?php

namespace App\Http\Traits\UserManagement;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


trait RoleTrait{
    public function getRole(){
       $roles=Role::all();
       return $roles ? $this->sendResponse($roles, 'Role Details!',200) 
       : $this->sendError('Role not found');

    }

    public function createRole(Request $request){
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));
        return $role ? $this->sendResponse($role, 'Role created Successfully!',201) 
        : $this->sendError('Role creation error');
    }

    public function showRole(Request $id){
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();

        return $rolePermissions ? $this->sendResponse($rolePermissions, 'Role Detail retrieved Successfully!', 200) 
            : $this->sendError('Role not found.');
    }

    public function updateRole(Request $id){
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
    
        $role->syncPermissions($request->input('permission'));
        return $role ? $this->sendResponse($role, 'Role Updated Successfully!!', 200)
         : $this->sendError('Role not able to update.');
    }

    public function deleteRole(Rewquest $id){
        $role = Role::find($id)->delete();       
        return $role ? $this->sendResponse($role, 'Role Delete Successfully!!', 200)
        : $this->sendError('Role not found.');
    }

}