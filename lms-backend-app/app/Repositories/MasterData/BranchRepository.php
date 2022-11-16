<?php

namespace App\Repositories\MasterData;
use Illuminate\Http\Request;
use App\Models\Branch;

class BranchRepository{

    public function saveBranch($branch){
        return $branch = Branch::create($branch->all());
    }

    public function getBranch() {
        return $branch = Branch::all();
    }

    public function showBranch($branchId)
    {
        return Branch::find($branchId);
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

    public function deleteBranch($branchId)
    { 
        return Branch::find($branchId)->delete();
    }
}