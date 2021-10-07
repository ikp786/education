<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|min:10|numeric|unique:users,mobile',
            'date_of_birth' => 'required',
            'address' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'profile_pic' => 'required|mimes:jpg,jpeg,png|max:2048'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        if($request->profile_pic) {
         $fileName = time().'_'.str_replace(" ","_",$request->profile_pic->getClientOriginalName());
         $filePath = $request->file('profile_pic')->storeAs('user-profile-photo', $fileName, 'public');
         $input['profile_pic'] = $fileName;
     }
     $input['password'] = bcrypt($input['password']);
     $user = User::create($input);
     $success['token'] =  $user->createToken('MyApp')->accessToken;
     $success['name'] =  $user->first_name;
     return $this->sendResponse($success, 'User register successfully.');
 }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            $success['name'] =  $user->name;
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }
}