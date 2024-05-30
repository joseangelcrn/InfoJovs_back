<?php

namespace App\Http\Controllers;

use App\Libs\ChartHelper;
use App\Models\CandidatureStatus;
use App\Models\Job;
use App\Models\ProfessionalProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    //

    public function search(Request $request)
    {
        $title = $request->get('title');
        $description = $request->get('description');
        $ignoreOwn = $request->get('ignore_own') == "true";

        $perPage = $request->get('perPage', 5);
        $currentPage = $request->get('currentPage', 1);


        $queryJobs = Job::query()->with(['tags']);

        if ($title) {
            $queryJobs = $queryJobs->where('title', 'like', "%$title%");
        }

        if ($description) {
            $queryJobs = $queryJobs->where('description', 'like', "%$description%");
        }

        if ($ignoreOwn and Auth::user()->hasRole('Recruiter')){
            $queryJobs = $queryJobs->where('recruiter_id','!=',Auth::id());
        }
        else if ($ignoreOwn and Auth::user()->hasRole('Employee')){
            $queryJobs = $queryJobs->whereDoesntHave('candidatures.employee',function($q){
                return $q->where('employee_id',Auth::id());
            });
        }

        $paginatedJobs = $queryJobs
            ->where('active',true)
            ->paginate($perPage, '*', null, $currentPage);

        return response()->json([
            'jobs' => $paginatedJobs->items(),
            'pagination' => [
                'perPage' => $paginatedJobs->perPage(),
                'currentPage' => $paginatedJobs->currentPage(),
                'lastPage' => $paginatedJobs->lastPage(),
                'totalItems' => $paginatedJobs->total()
            ]

        ]);
    }

    public function store(Request $request)
    {

        $title = $request->get('title');
        $description = $request->get('description');
        $tags = $request->get('tags', []);
        $questions = $request->get('questions');

        $newJob = Auth::user()->jobsAsRecruiter()->create([
            'title' => $title,
            'description' => $description,
            'questions' => json_encode($questions),
        ]);

        foreach ($tags as $tag) {
            $newJob->tags()->create(['name' => $tag]);
        }

        return response()->json([
            'message'=>'Job created successfully',
            'job'=>$newJob->load('tags')
        ]);
    }

    public function update(Request $request){

        $id = $request->get('id');
        $title = $request->get('title');
        $description = $request->get('description');
        $tags = $request->get('tags', []);
        $questions = $request->get('questions');

        $job = Job::findOrFail($id);

        if (Auth::id() != $job->recruiter_id){
            return response()->json(['message'=>'You can only update your own jobs'],400);
        }

        $job->title = $title;
        $job->description = $description;
        $job->questions = json_encode($questions);
        $job->save();

        foreach ($tags as $tag){
            $job->tags()->firstOrCreate(['name'=>$tag]);
        }

        $job->tags()->whereNotIn('name',$tags)->delete();

        return response()->json([
            'message'=>'You have successfully updated your job offer.',
            'job'=>$job
        ]);
    }

    public function info($id){

        $job = Job::With(['tags']   )->findOrFail($id);
        $alreadyRegistered = Auth::user()->candidatures()->where('job_id',$id)->exists();

        return response([
            'job'=>$job,
            'alreadyRegistered'=>$alreadyRegistered
        ]);
    }

    public function updateActiveValue(Request $request){
        $jobId = $request->get('id');
        $activeValue = $request->get('active');

        if (
            !Auth::user()->hasRole('Recruiter') or
            !Auth::user()->whereRelation('jobsAsRecruiter','id',$jobId)->exists()
        ){
            return response()->json([
                'message'=>'Unauthorized'
            ],401);
        }


        $result = Job::where('id',$jobId)->update(['active'=>$activeValue]);

        if ($result){
            $message = $activeValue ? 'The offer has been activated':  'Offer has been deactivated' ;
            return response()->json([
                'message'=>$message
            ]);
        }

        return response()->json([
            'message'=>'Something was wrong'
        ],500);
    }

    public function additionalInfo($id,$scope = 'main_info'){

        $job = Job::findOrFail($id);

        $result = $job->generateAdditionalInfo($scope);

        return response()->json($result);

    }
}
