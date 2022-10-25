<?php

namespace App\Http\Traits;
use Illuminate\Http\Request;
use App\Models\Department;

trait DepartmentTrait {

    public function getDepartment() {
        $dept = Department::all();
        return $dept ? $this->sendResponse($dept, 'Department Detail retrieved Successfully!') 
        : $this->sendError('Department not found');
    }

    public function createDepartment($request){
        $dept = Department::create($request->all());
        return $dept ? $this->sendResponse($dept, 'Department created Successfully!') 
        : $this->sendError('Department creation error');
    }

    public function showDepartment($id)
    {
        $dept= Department::find($id);
        return $dept ? $this->sendResponse($dept, 'Department Detail retrieved Successfully!') 
        : $this->sendError('Department not found');
    }

    public function updateDepartment($request, $id)
    {
        $dept = Department::find($id);
        $dept->department_code = $request->department_code;
        $dept->branch_id = $request->branch_id;
        $dept->department_name = $request->department_name;
        $dept->save();
        return $dept ? $this->sendResponse($dept,'Department Updated Successfully!!', 200)
         : $this->sendError('Department not able to update.');
    }

    public function deleteDepartment($id)
    { 
        $dept = Department::find($id)->delete();
        return $dept ? $this->sendResponse($dept, 'Department Deleted Successfully!!') 
        : $this->sendError('Department not found');
    }
}