<?php

namespace App\Http\Controllers;

use App\Libs\QuestionHelper;
use App\Models\Candidature;
use App\Models\CandidatureHistory;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidatureController extends Controller
{


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

    public function store(Request $request)
    {
        $jobId = $request->get('job_id');
        $questions = $request->get('questions');

        $job = Job::findOrFail($jobId);
        $questions = QuestionHelper::normalize($questions,[
            'remove_edit'
        ]);


        $newCandidature = Auth::user()->candidatures()->create(['job_id' => $job->id,'questions'=>json_encode($questions)]);

        CandidatureHistory::register($newCandidature->id);

        return response()->json([
            'message' => 'Candidature successfully created',
        ]);
    }

    public function info($jobId){


        $job = Job::with(['candidatures.status','candidatures.employee.professionalProfile'])->findOrFail($jobId);

        if ( !Auth::user()->hasRole('Recruiter') ||  Auth::id() != $job->recruiter_id){
            return response()->json([
                'message'=>'You can not see candidates of this job'
            ],401);
        }


        return response()->json([
            'candidatures'=> $job->candidatures
        ]);


    }

}
