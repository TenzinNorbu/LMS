<?php

namespace App\Http\Controllers\ApplicantModule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\LoanDetail;

class LoanDetailController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['loan']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loan=LoanDetail::all();
        return reponse()->json([
            'status'=> 'success',
            'load details'=> $loan
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
            'applicant_id' => 'required|string',
            'loan_type_id' => 'required|integer',
            'loan_amount' => 'required|integer',
            'loan_duration' => 'required|integer',
            'loan_start_date' => 'required|date',
            'loan_end_date' => 'required|date'
        ]);
        
        if(!($validator->fails())) {
            $loan = new LoanDetail;
            $loan->applicant_id = $request->applicant_id;
            $loan->loan_type_id = $request->loan_type_id;
            $loan->loan_amount = $request->loan_amount;
            $loan->loan_duration = $request->loan_duration;
            $loan->loan_start_date = $request->loan_start_date;
            $loan->loan_end_date = $request->loan_end_date;
            $loan->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Loan Detail added successfully',
            'loan detail' => $loan,
            ]);
        }
        else{
            return response()->json([
                'errors'=>$validator->errors()->all(),
                'message' => 'Loan detail submittion Failed'
            ],401);
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
        $loan = LoanDetail::all($id);
        return response()->json([
            'status' => 'success',
            'loan detail' => $loan
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
            'applicant_id' => 'required|string',
            'loan_type_id' => 'required|integer',
            'loan_amount' => 'required|integer',
            'loan_duration' => 'required|integer',
            'loan_start_date' => 'required|date',
            'loan_end_date' => 'required|date'
        ]);
        
            $loan = new LoanDetail;
            $loan->applicant_id = $request->applicant_id;
            $loan->loan_type_id = $request->loan_type_id;
            $loan->loan_amount = $request->loan_amount;
            $loan->loan_duration = $request->loan_duration;
            $loan->loan_start_date = $request->loan_start_date;
            $loan->loan_end_date = $request->loan_end_date;
            $loan->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Loan Detail updated successfully',
            'loan detail' => $loan,
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
        $loan=LoanDetail::fine($id);
        $loan->delete();
        return response()->json([
         'status'=> 'success',
         'message' => 'Loan detail deleted successfully',
         'loan detail' => $loan
        ]);
    }
}
