<?php

namespace App\Http\Traits;
use Illuminate\Http\Request;
use App\Models\Branch;

trait BranchTrait {

    public function getBranch() {
        $branch = Branch::all();
        return $branch ? $this->sendResponse($branch, 'Branch Detail retrieved Successfully!') 
        : $this->sendError('Branch not found');
    }

    public function createBranch($request){
        $branch = Branch::create($request->all());
        return $branch ? $this->sendResponse($branch, 'Branch created Successfully!') 
        : $this->sendError('Branch creation error');
    }

    public function showBranch($id)
    {
        $branch= Branch::find($id);
        return $branch ? $this->sendResponse($branch, 'Branch Detail retrieved Successfully!') 
        : $this->sendError('Branch not found');
    }

    public function updateBranch($request, $id)
    {
        $branch = Branch::find($id);
        $branch->branch_code = $request->branch_code;
        $branch->branch_name = $request->branch_name;
        $branch->save();
        return $branch ? $this->sendResponse($branch, 'Branch Updated Successfully!!', 200)
         : $this->sendError('Branch not able to update.');
    }

    public function deleteBranch($id)
    { 
        $branch = Branch::find($id)->delete();
        return $branch ? $this->sendResponse($branch, 'Branch Deleted Successfully!!') 
        : $this->sendError('Branch not found');
    }
}