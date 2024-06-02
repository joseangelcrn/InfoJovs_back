<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    //

    public function search(Request $request)
    {
        $title = $request->get('title');
        $description = $request->get('description');
        $ignoreOwn = $request->get('ignore_own') == "true";
        $tags = $request->get('tags');

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

        if ($tags){
            $queryJobs = $queryJobs->whereHas('tags',function($q) use ($tags){
                return $q->whereIn('name',$tags);
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

        if (!Auth::user()->hasRole('Recruiter')){
            return response()->json(['message'=>'Unauthorized'],Response::HTTP_UNAUTHORIZED);
        }

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


        if (
            !Auth::user()->hasRole('Recruiter') or
            (Auth::user()->hasRole('Recruiter') and !Auth::user()->jobsAsRecruiter()->where('id',$id)->exists())

        ){
            return response()->json(['message'=>'Unauthorized'],Response::HTTP_UNAUTHORIZED);
        }


        $job = Job::findOrFail($id);


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
            (Auth::user()->hasRole('Recruiter') and !Auth::user()->jobsAsRecruiter()->where('id',$jobId)->exists())

        ){
            return response()->json(['message'=>'Unauthorized'],Response::HTTP_UNAUTHORIZED);
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

        if (
            !Auth::user()->hasRole('Recruiter') or
            (Auth::user()->hasRole('Recruiter') and !Auth::user()->jobsAsRecruiter()->where('id',$id)->exists())

        ){
            return response()->json(['message'=>'Unauthorized'],Response::HTTP_UNAUTHORIZED);
        }


        $job = Job::findOrFail($id);

        $result = $job->generateAdditionalInfo($scope);

        return response()->json($result);

    }
}
