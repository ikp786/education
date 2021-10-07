<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\VideoController;
use App\Http\Controllers\API\UserController as APIUserController;
use App\Http\Controllers\API\EducationController as APIEducationController;
use App\Http\Controllers\API\EmploymentController as APIEmploymentController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);  
Route::get('login', [RegisterController::class, 'login'])->name('login');
Route::group(['middleware' => ['auth:api']], function(){ 
    Route::get('/user', function (Request $request){
        return $request->user();
    });

    //  EDUCATION ROUTE
    Route::resource('educations', APIEducationController::class);
    Route::post('educations/save', [APIEducationController::class,'store']);    
    Route::post('educations/update/{id}', [APIEducationController::class,'update']);    
    Route::get('educations/get-data/{id}', [APIEducationController::class,'getData']);

    //  Employment ROUTE
    Route::resource('employments', APIEmploymentController::class);
    Route::post('employments/save', [APIEmploymentController::class,'store']);    
    Route::post('employments/update/{id}', [APIEmploymentController::class,'update']);    
    Route::get('employments/get-data/{id}', [APIEmploymentController::class,'getData']);
    // EOC

    // RATING ROUTE
    Route::post('rattings/save-ratting',[APIUserController::class,'saveRatting'])->name('save.ratting');
    //EOC

    Route::post('change-email-status/{id}',[APIUserController::class,'changeEmailStatus'])->name('change-email-status');

    Route::post('upload-video', [VideoController::class, 'uploadVideo'])->name('upload-video');

    Route::post('update-profile', [APIUserController::class, 'updateProfile'])->name('update-profile');      

    Route::get('get-user-profile/{id}',[APIUserController::class,'getUserProfile'])->name('get-user-profile');

    Route::get('get-all-video',[VideoController::class,'getAllvideo'])->name('get-all-video');
    Route::get('delete-video/{id}',[VideoController::class,'deleteVideo'])->name('delete-video');    

    Route::get('get-my-video/{id}',[VideoController::class,'getMyVideo'])->name('get-my-video');

});