<?php

use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfessionalProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/signup',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);
Route::get('/professional_profiles/search',[ProfessionalProfileController::class,'search']);
Route::get('/roles',[RoleController::class,'getAll']);

//Protected routes
Route::group(['middleware' => ['auth:api']], function() {

    // User - routes
    Route::group(['prefix'=>'/user'],function(){
        Route::get('/info',[UserController::class,'info']);
        Route::post('/logout',[UserController::class,'logout']);
    });

    // Job - routes
    Route::group(['prefix'=>'/job'],function(){
        Route::post('/',[JobController::class,'store']);
        Route::get('/search',[JobController::class,'search']);
        Route::get('/{id}',[JobController::class,'info']);
        Route::put('/',[JobController::class,'update']);
        Route::get('/additional_info/{id}/{scope?}',[JobController::class,'additionalInfo']);
        Route::post('/update_active',[JobController::class,'updateActiveValue']);
    });

    //Candidature - routes
    Route::group(['prefix'=>'/candidature'],function(){
        Route::post('/',[CandidatureController::class,'store']);
        Route::get('/my_candidatures',[CandidatureController::class,'myCandidatures']);
        Route::get('/info/{jobId}',[CandidatureController::class,'info']);
        Route::get('/statuses',[CandidatureController::class,'getAllStatuses']);
    });

});
