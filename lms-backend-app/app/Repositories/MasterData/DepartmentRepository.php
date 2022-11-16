<?php

namespace App\Repositories\MasterData;
use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentRepository{
    public function saveDepartment($deptDetails){
        return $dept = Department::create($deptDetails->all());
    }

    public function getDepartment() {
        return $dept = Department::all();
    }

    public function showDepartment($deptId){
        return $dept= Department::find($deptId);
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

    public function deleteDepartment($deptId){ 
        return $dept = Department::find($deptId)->delete();
    }
}