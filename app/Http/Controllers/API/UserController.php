<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Education;
use App\Models\Employment;
use App\Models\Ratting;
use Validator;
use App\Http\Resources\UserResource;

class UserController extends BaseController
{
    public function updateProfile(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'user_id' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }            
        $user = User::find($request->user_id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->collage_name = $request->collage_name;
        $user->interested_video_language = $request->interested_video_language;
        $user->interested_video_category = $request->interested_video_category;
        $user->save();
        $success['first_name'] =  $user->first_name;
        return $this->sendResponse($success, 'User profile updated successfully.');
    }

    public function getUserProfile(Request $request, $id=null)
    {          
     try
     {
        $user_details = auth()->user()::with('educations', 'employments')->find($id);
        if($user_details) {
            return $this->sendResponse('user detail get successfully.', new UserResource($user_details));
        } else {
            return $this->sendFailed('User data not found', 200); 
        }
    }
    catch (\Throwable $e)
    {
        return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400);  
    } 
}

public function changeEmailStatus(Request $request, $id=null){
   if($id == null){
    return $this->sendError('Validation Error.', 'User Id cannot be blank.');
}
$user = User::find($id);
if (!isset($user['email_status'])) {
    return $this->sendError('Validation Error.', 'User Id Not found.');   
}
if ($user['email_status'] == 'Enable') {
    $user->email_status = 'Disable';
}else{
    $user->email_status = 'Enable';
}
$user->save();
$success['first_name'] =  $user['first_name'];
return $this->sendResponse($success, 'Email status change successfully.');
}

function saveRatting(Request $request){

    $validator = Validator::make($request->all(), [
        'user_id' => 'required',
        'ratting_user_id' => 'required',
        'ratting' => 'required|',
    ]);
    if($validator->fails()){
        return $this->sendError('Validation Error.', $validator->errors());
    }
    $checkExist = Ratting::where('ratting_user_id',$request->ratting_user_id)->where('user_id',$request->user_id)->get();
    if (isset($checkExist[0]->user_id)) {

        $update = Ratting::where('ratting_user_id', $request->ratting_user_id)->update($request->all());
        // check total ratting
        $collection = Ratting::where('user_id',$request->user_id)
        ->selectRaw('count(ratting_user_id) as total, SUM(ratting) as ratting')
        ->get();
        // calculate ratting
        $total_ratting = $collection[0]->ratting/$collection[0]->total;
        // update ratting
        $ratting_update = User::find($request->user_id);
        $ratting_update->ratting = $total_ratting;
        $ratting_update->save();
        $success =  'thanks for ratting';
        return $this->sendResponse($success, 'your ratting updated successfully.');
    }
    $input = $request->all();        
    $user = Ratting::create($input); 
    // $ratting_update = User::find($request->user_id);
    // $ratting_update->ratting = $ratting;
    // $ratting->save();

    $collection = Ratting::where('user_id',$request->user_id)
    ->selectRaw('count(ratting_user_id) as total, SUM(ratting) as ratting')
    ->get();
        // calculate ratting
    $total_ratting = $collection[0]->ratting/$collection[0]->total;
        // update ratting
    $ratting_update = User::find($request->user_id);
    $ratting_update->ratting = $total_ratting;
    $ratting_update->save();
    

    $success =  'thanks for ratting';
    return $this->sendResponse($success, 'your ratting saved successfully.');
}
}