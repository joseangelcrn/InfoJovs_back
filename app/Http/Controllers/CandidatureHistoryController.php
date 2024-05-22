<?php

namespace App\Http\Controllers;

use App\Models\CandidatureHistory;
use Illuminate\Http\Request;

class CandidatureHistoryController extends Controller
{
    //
    public function getHistory($jobId)
    {

        $history = \Auth::user()->candidaturesHistory()
            ->whereRelation('candidature.job','id',$jobId)
            ->get();

        return response()->json($history);
    }
}
