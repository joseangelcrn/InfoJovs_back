<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JobController extends Controller
{
    //

    public function search(Request $request){
        $title = $request->get('title');
        $description = $request->get('description');

        $perPage = $request->get('perPage',5);
        $currentPage = $request->get('currentPage',1);


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
            'pagination'=>[
                'perPage'=>$paginatedJobs->perPage(),
                'currentPage'=>$paginatedJobs->currentPage(),
                'lastPage'=>$paginatedJobs->lastPage(),
                'totalItems'=>$paginatedJobs->total()
            ]

        ]);
    }
}
