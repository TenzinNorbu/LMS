<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\BranchExtention;


class BranchExtentionController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['branch_extention']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branch_extention=BranchExtention::all();
        return response()->json([
            'status' => 'success',
            'branch_extension' => $branch_extention
        ]);
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
            'name' => 'required|string|between:2,100',
        ]);
        
        if(!($validator->fails())) {
            $branch_extention = new BranchExtention;
            $branch_extention->name = $request->name;
            $branch_extention->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Branch Extention successfully Registered',
            'branch_extention' => $branch_extention,
            ]);
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
        $branch_extention= BranchExtention::find($id);
        return response()->json([
            'status'=> 'success',
            'branch_extention'=>$branch_extention
        ]);
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
            'name' => 'required|string|between:2,100',
        ]);

        $branch_extention = BranchExtention::find($id);
        $branch_extention->name = $request->name;
        $branch_extention->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Branch Extention Updated successfully',
            'branch_extention' => $branch_extention
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $branch_extention = BranchExtention::find($id);
        $branch_extention->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Branch Extension deleted successfully',
            'branch_extention' => $branch_extention,
        ]);
    }
}
