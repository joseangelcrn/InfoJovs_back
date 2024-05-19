<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\CandidatureHistory;
use App\Models\CandidatureStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CandidatureStatusController extends Controller
{
    //
    public function getAll(){
        $statuses = CandidatureStatus::all();
        return response()->json($statuses);
    }

    public function update(Request $request)
    {
        $candidatureIds = $request->get('candidature_ids');
        $statusId = $request->get('status_id');

        $status = CandidatureStatus::findOrFail($statusId);
        $candidatures =Candidature::whereIn('id',$candidatureIds)->get();

        Candidature::whereIn('id',$candidatureIds)->update(['status_id' => $statusId]);

        $historyInserts = [];

        foreach ($candidatures as $candidature) {
            $historyInserts[] = [
                'candidature_id' => $candidature->id,
                'origin_status_id' => $candidature->status_id,
                'destiny_status_id' => $statusId,
                'recruiter_id'=>\Auth::id(),
                'created_at' => Carbon::now(),
            ];
        }


        CandidatureHistory::insert($historyInserts);

        return response()->json([
            'message' => 'Status updated successfully',
            'updated_data'=>[
                'new_status' => $status,
                'candidature_ids' => $candidatureIds
            ]
        ]);
    }
}
