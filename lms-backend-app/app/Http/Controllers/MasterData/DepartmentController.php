<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['department']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $department=Department::all();
        return $this->sendResponse($department, 'Department details retrieved successfully.');
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
            $department = new Department;
            $department->name = $request->name;
            $department->save();

            return $this->sendResponse($department,'Department Created Successfully!',201);

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
        $department= Department::find($id);
        return $department ? $this->sendResponse($department, 'Department Detail Retrieved Successfully!!', 200) 
        : $this->sendError('Department not found.');
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

        $department = Department::find($id);
        $department->name = $request->name;
        $department->save();

        return $department ? $this->sendResponse($department, 'Department Updated Successfully!!', 200) 
        : $this->sendError('Department not found.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $department = Department::find($id);
        $department->delete();
        return $department ? $this->sendResponse($department, 'Department Deleted Successfully!!', 200) 
        : $this->sendError('Department not found.');
    }
}
