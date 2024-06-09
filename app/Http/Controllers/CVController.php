<?php

namespace App\Http\Controllers;

use App\Models\CV;
use Illuminate\Http\Request;

class CVController extends Controller
{
    public function info($userId = null)
    {
        $userId = $userId ?? \Auth::id();

        if (\Auth::id() != $userId and !\Auth::user()->hasRole('Recruiter')){
            return response()->json([
                'message'=>'You can not see this CV'
            ],401);
        }
        $cv = CV::with(['experiences','skills'])->where('user_id',$userId)->first();

        return response()->json([
            'cv'=>$cv
        ]);
    }
}
