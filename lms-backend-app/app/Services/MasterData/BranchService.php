<?php

namespace App\Services\MasterData;

use App\Repositories\MasterData\BranchRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\MasterData\StoreBranchRequest;


class BranchService{
    public function __construct(BranchRepository $branchRepository){
        $this->branchRepository = $branchRepository;
    }

    public function saveBranch(StoreBranchRequest $branch){
        $validated = $branch->validated();
        return $validated ? $this->branchRepository->saveBranch($branch):$this->sendError('Validation Fail');
    }

    public function getBranch(){
        return $this->branchRepository->getBranch();
    }

    public function showBranch($branchId){
        return $this->branchRepository->showBranch($branchId);
    }

    public function updateBranch($request, $id){
        $branch = Branch::find($id);
        $branch->branch_code = $request->branch_code;
        $branch->branch_name = $request->branch_name;
        $branch->save();
        return $branch ? $this->sendResponse($branch, 'Branch Updated Successfully!!', 200)
         : $this->sendError('Branch not able to update.');
    }

    public function deleteBranch($branchId){
        return $this->branchRepository->deleteBranch($branchId); 
    }
}