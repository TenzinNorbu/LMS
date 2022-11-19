<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MasterData\StoreDepartmentRequest;
use App\Services\MAsterData\DepartmentService;

class DepartmentController extends Controller{
    public function __construct(DepartmentService $departmentService){
        $this->departmentService = $departmentService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
       $dept=$this->departmentService->getDepartment();
       return $dept ? $this->sendResponse($dept, 'Department Details retrieved Successfully!') : $this->sendError('Department not found');
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
    public function store(StoreDepartmentRequest $deptDetails){
         $dept=$this->departmentService->createDepartment($deptDetails);
         return $dept ? $this->sendResponse($dept, 'Department created Successfully!') : $this->sendError('Department creation error');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($deptId){
        $dept= $this->departmentService->showDepartment($deptId);
        return $dept ? $this->sendResponse($dept, 'Department details retrieved Successfully!') : $this->sendError('Department not found');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreDepartmentRequest $dept, $deptId){
      $dept=$this->updateDepartment($dept, $deptId);
      return $dept ? $this->sendResponse($dept,'Department Updated Successfully!!', 200): $this->sendError('Department not able to update.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($deptId){
        $dept=$this->departmentService->deleteDepartment($deptId);
        return $dept ? $this->sendResponse($dept, 'Department Deleted Successfully!!') : $this->sendError('Department not found');
    }
}
