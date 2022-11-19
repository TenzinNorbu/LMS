<?php

namespace App\Repositories\MasterData;
use Illuminate\Http\Request;
use App\Models\Branch;

class BranchRepository{

    public function __construct(Branch $branch){
        $this->branch = $branch;
    }

    public function saveBranch($branch){
        return $this->branch->create($branch->all());
    }

    public function getBranch(){
        return $this->branch->get();
    }

    public function showBranch($branchId){
        return $this->branch->find($branchId);
    }

    public function updateBranch($branch,$branchId){
        $branch =$this->branch->find($branchId);
        $branch->branch_code = $request->branch_code;
        $branch->branch_name = $request->branch_name;
        return $branch->save();
    }

    public function deleteBranch($branchId){ 
        return $this->branch->destroy($branchId)->delete();
    }
}