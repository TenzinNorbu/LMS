<?php

namespace App\Http\Controllers\UserManagementModule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserManagement\StoreRoleRequest;
use App\Services\RoleService;
use App\Repositories\RoleRepository;


class RoleController extends Controller
{
    private $roleRepository, $roleService;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function  __construct(RoleRepository $roleRepository, RoleService $roleService){
        $this->roleRepository=$roleRepository;
        $this->roleService=$roleService;
    }
    public function index()
    {
        $roles= $this->roleRepository->getRole();
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
    public function store(StoreRoleRequest $request)
    {
        $role = $this->roleRepository->createRole($request);
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
        $rolePermissions=$this->roleRepository->showRole($roleId);
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
        $role = $this->roleRepository->deleteRole($roleId);
        return $role ? $this->sendResponse($role, 'Role Delete Successfully!!', 200)
        : $this->sendError('Role not found.');
    }
}
