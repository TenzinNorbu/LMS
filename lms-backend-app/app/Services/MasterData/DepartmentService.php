<?php

namespace App\Services\MasterData;
use Illuminate\Http\Request;
use App\Http\Requests\MasterData\StoreDepartmentRequest;
use App\Repositories\MasterData\DepartmentRepository;

class DepartmentService{
    public function __construct(DepartmentRepository $departmentRepository) {
        $this->departmentRepository = $departmentRepository;
    }

    public function createDepartment(StoreDepartmentRequest $deptDetails){
        $validated = $deptDetail->validated();
        return $validated ? $this->departmentRepository->saveDepartment($deptDetails):$this->sendError('Validation Fail');
    }

    public function getDepartment() {
        return $this->departmentRepository->getDepartment(); 
    }

    public function showDepartment($deptId){
        return $this->departmentRepository->showDepartment($deptId);
    }

    public function updateDepartment($request, $id){
        $dept = Department::find($id);
        $dept->department_code = $request->department_code;
        $dept->branch_id = $request->branch_id;
        $dept->department_name = $request->department_name;
        $dept->save();
        return $dept ? $this->sendResponse($dept,'Department Updated Successfully!!', 200)
         : $this->sendError('Department not able to update.');
    }

    public function deleteDepartment($deptDetails){ 
        return $this->departmentRepository->deleteDepartment($deptDetails);  
    }
}