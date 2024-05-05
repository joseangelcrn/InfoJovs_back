<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidatureController extends Controller
{
    //
    public function myCandidatures(Request $request){

        $perPage = $request->get('perPage',5);
        $currentPage = $request->get('currentPage',1);

        $paginatedCandidatures = Candidature::with(['status','job'])->where('employee_id',Auth::id())->paginate($perPage,'*',null,$currentPage);

        return response()->json([
            'candidatures'=>$paginatedCandidatures->items(),
            'pagination'=>[
                'perPage'=>$paginatedCandidatures->perPage(),
                'currentPage'=>$paginatedCandidatures->currentPage(),
                'lastPage'=>$paginatedCandidatures->lastPage(),
                'totalItems'=>$paginatedCandidatures->total()
            ]

        ]);
    }

    public function store(Request $request){
        $jobId = $request->get('job_id');

        $job = Job::findOrFail($jobId);

        Auth::user()->candidatures()->firstOrCreate(['job_id'=>$job->id]);

        return response()->json([
            'message'=>'Candidature successfully created',
        ]);
    }
}
