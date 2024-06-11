<?php

use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\CandidatureHistoryController;
use App\Http\Controllers\CandidatureStatusController;
use App\Http\Controllers\CVController;
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

Route::post('/signup',[UserController::class,'register'])->name('signup');
Route::post('/login',[UserController::class,'login'])->name('login');
Route::get('/professional_profiles/search',[ProfessionalProfileController::class,'search'])->name('professionalProfile.search');
Route::get('/roles',[RoleController::class,'getAll'])->name('roles.getAll');

//Protected routes
Route::group(['middleware' => ['auth:api']], function() {

    // User - routes
    Route::group(['prefix'=>'/user'],function(){
        Route::get('/info',[UserController::class,'info'])->name('user.info');
        Route::post('/logout',[UserController::class,'logout'])->name('logout');
    });

    // Job - routes
    Route::group(['prefix'=>'/job'],function(){
        Route::post('/',[JobController::class,'store'])->name('job.store');
        Route::get('/search',[JobController::class,'search'])->name('job.search');
        Route::get('/{id}',[JobController::class,'info'])->name('job.info');
        Route::put('/',[JobController::class,'update'])->name('job.update');
        Route::get('/additional_info/{id}/{scope?}',[JobController::class,'additionalInfo'])->name('job.additionalInfo');
        Route::post('/update_active',[JobController::class,'updateActiveValue'])->name('job.updateActive');
    });

    //Candidature - routes
    Route::group(['prefix'=>'/candidature'],function(){
        Route::post('/',[CandidatureController::class,'store'])->name('candidature.store');
        Route::get('/my_candidatures',[CandidatureController::class,'myCandidatures'])->name('candidature.myCandidatures');
        Route::get('/info/{jobId}',[CandidatureController::class,'info'])->name('candidature.info');


        //CandidatureStatus - routes
        Route::group(['prefix'=>'/status'],function(){
            Route::get('/',[CandidatureStatusController::class,'getAll'])->name('candidatureStatus.store');
            Route::post('/',[CandidatureStatusController::class,'update'])->name('candidatureStatus.update');

        });


        //CandidatureHistory - routes
        Route::group(['prefix'=>'/history'],function(){
            Route::get('/{jobId}',[CandidatureHistoryController::class,'getHistory'])->name('candidatureHistory.getHistory');
        });
    });

    //Cv - routes
    Route::group(['prefix'=>'/cv'],function(){
        Route::get('/info/{userId?}',[CVController::class,'info'])->name('cv.info');
        Route::post('/',[CVController::class,'save'])->name('cv.save');
    });


});
