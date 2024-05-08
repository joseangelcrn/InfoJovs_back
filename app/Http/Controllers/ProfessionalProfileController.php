<?php

namespace App\Http\Controllers;

use App\Models\ProfessionalProfile;
use Illuminate\Http\Request;

class ProfessionalProfileController extends Controller
{
    //
    public function search(Request $request)
    {
        $roleId = $request->get('role_id');
        $title = $request->get('title');

        $profiles = ProfessionalProfile::where('title', 'like', "%$title%");

        if ($roleId){
            $profiles->where('role_id',$roleId);
        }

        $profiles = $profiles->get();

        return response()->json($profiles);
    }
}
