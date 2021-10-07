<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Employment;
use Validator;
class EmploymentController extends BaseController
// class EmploymentController extends BaseController;
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function getData($id)
    {     
        if($id == null){
            return $this->sendError('Validation Error.', 'User Id cannot be blank.');
        }            
        $Employment = Employment::where('user_id',$id)->get();
        $success =  $Employment;
        return $this->sendResponse($success, 'get Employment Detail successfully.');
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
        $error_message =    [
            'user_id .required'    => 'User Id  should be required',            
            'company_name.required'=> 'Company Name should be required',           
            'joining_date.required'=> 'Joining Date should be required',            
            'relieving_date.required'   => 'Relieving Date should be required',
            'salary_per_annum.required'  => 'Salary Per Annum should be required',
            'city.required'=> 'City should be required',            
        ];
        $rules = [
            'user_id'             => 'required',
            'company_name'         => 'required',
            'joining_date'         => 'required',
            'relieving_date'            => 'required',
            'salary_per_annum'           => 'required',
            'city'          => 'required',
        ];
        $validator = Validator::make($request->all(), $rules, $error_message);
        if($validator->fails()){
            return $this->sendError(implode(", ",$validator->errors()->all()), 200);     
        }        
        try
        {             
            \DB::beginTransaction();
            $Employment = new Employment();
            $Employment->fill($request->all());
            $Employment->save();
            \DB::commit();
            return $this->sendResponse('','Employment Detail save successfully');
        }
        catch (\Throwable $e)
        {
            \DB::rollback();
            return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400);  
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
        //
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

     $error_message =    [
            'user_id .required'    => 'User Id  should be required',            
            'company_name.required'=> 'Company Name should be required',           
            'joining_date.required'=> 'Joining Date should be required',            
            'relieving_date.required'   => 'Relieving Date should be required',
            'salary_per_annum.required'  => 'Salary Per Annum should be required',
            'city.required'=> 'City should be required',            
        ];
        $rules = [
            'user_id'             => 'required',
            'company_name'         => 'required',
            'joining_date'         => 'required',
            'relieving_date'            => 'required',
            'salary_per_annum'           => 'required',
            'city'          => 'required',
        ];
    $validator = Validator::make($request->all(), $rules, $error_message);
    if($validator->fails()){
        return $this->sendError(implode(", ",$validator->errors()->all()), 200);     
    }        
    try
    {             
        \DB::beginTransaction();
        $Employment = Employment::find($id);
        $Employment->fill($request->all());
        $Employment->save();
        \DB::commit();
        return $this->sendResponse('','Employment Detail update successfully');
    }
    catch (\Throwable $e)
    {
        \DB::rollback();
        return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400);  
    }   
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if($id == null){
            return $this->sendError('Validation Error.', 'Employment Id cannot be blank.');
        }  
        $video = Employment::find( $id );
        if (empty($video)) {
            return $this->sendError('Validation Error.', 'Employment Id is not available.');
        }          
        try
        {             
            \DB::beginTransaction();
            $Employment = Employment::find($id);
            $Employment->delete();            
            \DB::commit();
            return $this->sendResponse('','Employment Detail delete successfully');
        }
        catch (\Throwable $e)
        {
            \DB::rollback();
            return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400); 
        }   
    }
}