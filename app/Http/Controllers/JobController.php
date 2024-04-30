<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    //

    public function search(Request $request){
        $title = $request->get('filter_title');
        $description = $request->get('filter_description');

        $perPage = $request->get('per_page');
        $currentPage = $request->get('current_page');


        $queryJobs = Job::query();

        if ($title){
            $queryJobs = $queryJobs->where('title','like',"%$title%");
        }

        if ($description){
            $queryJobs = $queryJobs->where('description','like',"%$description%");
        }

        $paginatedJobs = $queryJobs->paginate($perPage,'*',null,$currentPage);

        return response()->json([
            'jobs'=>$paginatedJobs->items(),
            'per_page'=>$paginatedJobs->perPage(),
            'current_page'=>$paginatedJobs->currentPage(),
            'total_page'=>$paginatedJobs->total()
        ]);
    }
}
