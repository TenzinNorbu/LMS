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

    public function updateDepartment(StoreDepartmentRequest $deptDetails,$deptId){
        $validated = $deptDetails->validated();
        return $validated ? $this->branchRepository->updateDepartment($deptDetails, $deptId):$this->sendError('Validation Fail');
    }

    public function deleteDepartment($deptDetails){ 
        return $this->departmentRepository->deleteDepartment($deptDetails);  
    }
}