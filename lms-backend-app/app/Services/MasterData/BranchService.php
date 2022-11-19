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

    public function updateBranch(StoreBranchRequest $branch, $branchId){
        $validated = $branch->validated();
        return $validated ? $this->branchRepository->updateBranch($branch, $branchId):$this->sendError('Validation Fail');
    }

    public function deleteBranch($branchId){
        return $this->branchRepository->deleteBranch($branchId); 
    }
}