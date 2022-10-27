<?php

namespace App\Http\Traits\UserManagement;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

trait PermissionTrait{
    public function getPermission(){
       $permissions=Permission::all();
       return $permissions ? $this->sendResponse($permissions, 'Permission Details!',200) 
       : $this->sendError('Permission not found');
    }

    public function createPermission(Request $request){
        $permission = Permission::create(['permission' => $request->input('permission')]);
        return $permission ? $this->sendResponse($permission, 'Permission created Successfully!',201) 
        : $this->sendError('Permission creation error');
    }

    public function showPermission(Request $id){
        $permission = Permission::find($id);
        return $permission ? $this->sendResponse($permission, 'Permission Detail retrieved Successfully!', 200) 
            : $this->sendError('Permission not found.');
    }

    public function updatePermission(Request $id){
        $permission = Permission::find($id);
        $permission->permission = $request->input('permission');
        $permission->save();
    
        return $permission ? $this->sendResponse($permission, 'Permission Updated Successfully!!', 200)
         : $this->sendError('Permission not able to update.');
    }

    public function deletePermission(Rewquest $id){
        $permission = Permission::find($id)->delete();       
        return $permission ? $this->sendResponse($permission, 'Permission Delete Successfully!!', 200)
        : $this->sendError('Permission not found.');
    }

}