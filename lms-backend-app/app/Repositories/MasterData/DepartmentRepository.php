<?php

namespace App\Repositories\MasterData;
use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentRepository{
    public function __construct(Department $department){
        $this->department = $department;
    }

    public function saveDepartment($deptDetails){
        return $this->department->create($deptDetails->all());
    }

    public function getDepartment(){
        return $this->department->get();
    }

    public function showDepartment($deptId){
        return $this->department->find($deptId);
    }

    public function updateDepartment($deptDetails, $deptId){
        $dept =$this->department->find($deptId);
        $dept->department_code = $deptDetails->department_code;
        $dept->branch_id = $deptDetails->branch_id;
        $dept->department_name = $deptDetails->department_name;
        return $dept->save();
    }

    public function deleteDepartment($deptId){ 
        return $this->department->destroy($deptId);
    }
}