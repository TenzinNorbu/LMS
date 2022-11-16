<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MasterData\StoreBranchRequest;
use App\Services\MasterData\BranchService;

class BranchController extends Controller
{
    public function __construct(BranchService $branchService) 
    {
        $this->branchService = $branchService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $branch= $this->branchService->getBranch();
         return $branch ? $this->sendResponse($branch, 'Branch Detail retrieved Successfully!') 
         : $this->sendError('Branch not found'); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBranchRequest $branch)
    {
         $branch= $this->branchService->saveBranch($branch);
         return $branch ? $this->sendResponse($branch, 'Branch created Successfully!') 
         : $this->sendError('Branch creation error');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($branchId)
    {
        $branch=$this->branchService->showBranch($branchId);
        return $branch ? $this->sendResponse($branch, 'Branch Detail retrieved Successfully!') 
        : $this->sendError('Branch not found');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBranchRequest $request,$branchId)
    {
        return $this->branchService->updateBranch($request,$branchId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($branchId)
    {
        $branch= $this->branchService->deleteBranch($branchId);
        return $branch ? $this->sendResponse($branch, 'Branch Deleted Successfully!!') 
        : $this->sendError('Branch not found');

    }
}
