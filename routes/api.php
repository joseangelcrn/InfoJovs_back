<?php

use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\JobController;
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

Route::post('/signup',[\App\Http\Controllers\UserController::class,'register']);
Route::post('/login',[\App\Http\Controllers\UserController::class,'login']);

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
    });

    //Candidature - routes
    Route::group(['prefix'=>'/candidature'],function(){
        Route::get('/my_candidatures',[CandidatureController::class,'myCandidatures']);
    });

});
