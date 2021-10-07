<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Education;
use Validator;
class EducationController extends BaseController
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
        $education = auth()->user()->educations;
        $success =  $education;
        return $this->sendResponse($success, 'get Education Detail successfully.');
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
            'title.required'=> 'Title should be required',           
            'passing_year.required'=> 'Passing Year should be required',            
            'total_marks.required'   => 'Total Marks should be required',
            'obtain_marks.required'  => 'Obtain Marks should be required',
            'university_name.required'=> 'University Name should be required',            
        ];
        $rules = [
            'user_id'             => 'required|numeric',
            'title'         => 'required',
            'passing_year'         => 'required',
            'total_marks'            => 'required',
            'obtain_marks'           => 'required',
            'university_name'          => 'required',
        ];

        $validator = Validator::make($request->all(), $rules, $error_message);

        if($validator->fails()){
            return $this->sendError(implode(", ",$validator->errors()->all()), 200);     
        }        
        try
        {             
            \DB::beginTransaction();
            $education = new Education();
            $education->fill($request->all());
            $education->save();
            \DB::commit();
            return $this->sendResponse('','Education Detail save successfully');
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
        'title.required'=> 'Title should be required',           
        'passing_year.required'=> 'Passing Year should be required',            
        'total_marks.required'   => 'Total Marks should be required',
        'obtain_marks.required'  => 'Obtain Marks should be required',
        'university_name.required'=> 'University Name should be required',            
    ];
    $rules = [
        'user_id'             => 'required|numeric',
        'title'         => 'required',
        'passing_year'         => 'required',
        'total_marks'            => 'required',
        'obtain_marks'           => 'required',
        'university_name'          => 'required',
    ];
    $validator = Validator::make($request->all(), $rules, $error_message);
    if($validator->fails()){
        return $this->sendError(implode(", ",$validator->errors()->all()), 200);     
    }        
    try
    {             
        \DB::beginTransaction();
        $education = Education::find($id);
        $education->fill($request->all());
        $education->save();
        \DB::commit();
        return $this->sendResponse('','Education Detail update successfully');
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
            return $this->sendError('Validation Error.', 'Education Id cannot be blank.');
        }  
        $video = Education::find( $id );
        if (empty($video)) {
            return $this->sendError('Validation Error.', 'Education Id is not available.');
        }          
        try
        {             
            \DB::beginTransaction();

            $education = Education::find($id);
            $education->delete();            
            \DB::commit();
            return $this->sendResponse('','Education Detail delete successfully');
        }
        catch (\Throwable $e)
        {
            \DB::rollback();
            return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400); 
        }   
    }
}