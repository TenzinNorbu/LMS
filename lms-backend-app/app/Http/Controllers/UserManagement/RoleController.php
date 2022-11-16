<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserManagement\StoreRoleRequest;
use App\Services\UserManagement\RoleService;


class RoleController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function  __construct(RoleService $roleService)
    {
        $this->roleService=$roleService;
    }
    public function index()
    {
        $roles= $this->roleService->getRole();
        return $roles ? $this->sendResponse($roles, 'Role Details!',200) 
        : $this->sendError('Role not found');
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
    public function store(StoreRoleRequest $role)
    {
        $role = $this->roleService->createRole($role);
        return $role ? $this->sendResponse($role, 'Role created Successfully!',201) 
        : $this->sendError('Role creation error');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($roleId)
    {
        $rolePermissions=$this->roleService->showRole($roleId);
        return $rolePermissions ? $this->sendResponse($rolePermissions, 'Role Detail retrieved Successfully!', 200) 
            : $this->sendError('Role not found.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRoleRequest $request, $roleId)
    {
        $role =$this->roleRepository->updateRole($request, $roleId);
        return $role ? $this->sendResponse($role, 'Role Updated Successfully!!', 200)
        : $this->sendError('Role not able to update.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($roleId)
    {
        $role = $this->roleService->deleteRole($roleId);
        return $role ? $this->sendResponse($role, 'Role Delete Successfully!!', 200)
        : $this->sendError('Role not found.');
    }
}
