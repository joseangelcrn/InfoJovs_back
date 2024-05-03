<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class JobController extends Controller
{
    //

    public function search(Request $request)
    {
        $title = $request->get('title');
        $description = $request->get('description');

        $perPage = $request->get('perPage', 5);
        $currentPage = $request->get('currentPage', 1);


        $queryJobs = Job::query();
        $queryJobs = $queryJobs->with(['tags']);

        if ($title) {
            $queryJobs = $queryJobs->where('title', 'like', "%$title%");
        }

        if ($description) {
            $queryJobs = $queryJobs->where('description', 'like', "%$description%");
        }

        $paginatedJobs = $queryJobs->paginate($perPage, '*', null, $currentPage);

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


        $newJob = Auth::user()->jobsAsRecruiter()->create([
            'title' => $title,
            'description' => $description
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

        $job = Job::findOrFail($id);

        if (Auth::id() != $job->recruiter_id){
            return response()->json(['message'=>'You can only update your own jobs'],400);
        }

        $job->title = $title;
        $job->description = $description;
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

        return response([
            'job'=>$job
        ]);
    }
}
