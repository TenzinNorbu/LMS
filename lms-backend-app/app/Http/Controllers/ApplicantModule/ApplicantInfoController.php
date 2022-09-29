<?php

namespace App\Http\Controllers\ApplicantModule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ApplicantInfo;
use Illuminate\Support\Facades\Crypt;


class ApplicantInfoController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['applicant']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applicants=ApplicantInfo::all();
        return $this->sendResponse($applicants, 'Applicant details.');

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
            'cid_no' => 'required|string|min:11|max:11',
            'name' => 'required|string|between:2,100',
            'gender' => 'required|string',
            'contact_no' => 'required|integer',
            'dzongkhag_id' => 'required|integer',
            'gewog_id' => 'required|integer',
            'village_id' => 'required|integer'
        ]);
        
        if(!($validator->fails())) {
            $applicant = new ApplicantInfo;
            $applicant->cid_no =Crypt::encryptString($request->cid_no);
            $applicant->name =Crypt::encryptString($request->name);
            $applicant->gender = $request->gender;
            $applicant->dzongkhag_id = $request->dzongkhag_id;
            $applicant->gewog_id = $request->gewog_id;
            $applicant->village_id = $request->village_id; 
            $applicant->contact_no =Crypt::encryptString($request->contact_no);
            $applicant->save();

            return $this->sendResponse($applicant,'Applicant Created Successfully!',201);
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
        $applicant=ApplicantInfo::find($id);
        return $applicant ? $this->sendResponse($applicant, 'Applicant Detail retrieved Successfully!', 200) 
            : $this->sendError('Applicant not found.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
            'cid_no' => 'required|string|min:11|max:11',
            'gender' => 'required|string',
            'contact_no' => 'required|integer',
            'dzongkhag_id' => 'required|integer',
            'gewog_id' => 'required|integer',
            'village_id' => 'required|integer'
        ]);
        
            $applicant =ApplicantInfo::find($id);
            $applicant->cid_no =Crypt::encryptString($request->cid_no);
            $applicant->name =Crypt::encryptString($request->name);
            $applicant->gender = $request->gender;
            $applicant->dzongkhag_id = $request->dzongkhag_id;
            $applicant->gewog_id = $request->gewog_id;
            $applicant->village_id = $request->village_id; 
            $applicant->contact_no =Crypt::encryptString($request->contact_no);
            $applicant->save();

            return $applicant ? $this->sendResponse($applicant, 'Applicant Updated Successfully!', 200) 
            : $this->sendError('Applicant not found.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $applicant = ApplicantInfo::find($id);
        $applicant->delete();
        
        return $applicant ? $this->sendResponse($applicant, 'Applicant Deleted Successfully!', 200) 
        : $this->sendError('Applicant not found.');

    }
}
