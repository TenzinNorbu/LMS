<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Branch;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branchs=Branch::all();
         return $this->sendResponse($branchs, 'Branch details retrieved successfully.');

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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'branch_code' => 'required|string|between:2,100',
            'branch_name' => 'required|string|between:2,100',
        ]);
        
        if(!($validator->fails())) {
            $branch = new Branch;
            $branch->branch_code = $request->branch_code;
            $branch->branch_name = $request->branch_name;
            $branch->save();

        return $this->sendResponse($branch,'Branch Created Successfully!',201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $branch= Branch::find($id);
        return $branch ? $this->sendResponse($branch, 'Branch Detail retrieved Successfully!', 200) 
        : $this->sendError('Branch not found.');
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
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'branch_code' => 'required|string|between:2,100',
            'branch_name' => 'required|string|between:2,100',
        ]);

        $branch = Branch::find($id);
        $branch->branch_code = $request->branch_code;
        $branch->branch_name = $request->branch_name;
        $branch->save();

        return $branch ? $this->sendResponse($branch, 'Branch Updated Successfully!!', 200)
         : $this->sendError('Branch not found.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $branch = Branch::find($id);
        $branch->delete();
        return $branch ? $this->sendResponse($branch, 'Branch Delated Successfully!!', 200) 
        : $this->sendError('Branch not found.');
    }
}
