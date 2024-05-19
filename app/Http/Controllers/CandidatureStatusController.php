<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\CandidatureStatus;
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
        Candidature::whereIn('id',$candidatureIds)->update(['status_id' => $statusId]);

        return response()->json([
            'message' => 'Status updated successfully',
            'updated_data'=>[
                'new_status' => $status,
                'candidature_ids' => $candidatureIds
            ]
        ]);
    }
}
