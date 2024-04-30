<?php

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

Route::post('/register',[\App\Http\Controllers\UserController::class,'register']);
Route::post('/login',[\App\Http\Controllers\UserController::class,'login']);

//Protected routes
Route::group(['middleware' => ['auth:api']], function() {

    // User - routes
    Route::group(['prefix'=>'/user'],function(){
        Route::get('/info',[\App\Http\Controllers\UserController::class,'info']);
    });

    // Job - routes
    Route::group(['prefix'=>'/job'],function(){
        Route::get('/search',[\App\Http\Controllers\JobController::class,'search']);
    });

    Route::post('/logout',[\App\Http\Controllers\UserController::class,'logout']);
});
