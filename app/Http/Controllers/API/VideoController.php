<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Video;
use Validator;
class VideoController extends BaseController
{
    public function uploadVideo(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'video_language' => 'required|',
            'user_id' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        if($request->video) {
            $fileName = rand(1000,9999).'_'.time().'_'.str_replace(" ","_",$request->video->getClientOriginalName());
            $filePath = $request->file('video')->storeAs('video/'.$request->user_id, $fileName, 'public');
            $input['video'] = $fileName;
        }
        $video = Video::create($input);   
        $success['title'] =  $video->title;
        return $this->sendResponse($success, 'video uploaded successfully.');
    }

    public function getAllvideo(Request $request)
    {
        $video = Video::orderBy('updated_at', 'desc')->get();        
        $success['video'] =  $video->title;
        return $this->sendResponse($success, 'all video get successfully.');
    }

    public function getMyVideo(Request $request,$id=null){
         if($id == null){
            return $this->sendError('Validation Error.', 'Video Id is not available.');
        }        
        $video = Video::where('user_id',$id)->orderBy('updated_at', 'desc')->get();
        if (empty($video)){
            return $this->sendError('Error.', 'Video not found yet know.');
        }
        $success['video'] =  $video;
        return $this->sendResponse($success, 'my video get successfully.');
    }

    public function deleteVideo($id=null)
    {        
        if($id == null){
            return $this->sendError('Validation Error.', 'Video Id cannot be blank.');
        }  
        $video = Video::find( $id );
        if (empty($video)) {
            return $this->sendError('Validation Error.', 'Video Id is not available.');
        }
        $video->delete();
        $success['video'] =  $video->title;
        return $this->sendResponse($success, 'video deleted successfully');
    }
}