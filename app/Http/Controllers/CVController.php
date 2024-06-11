<?php

namespace App\Http\Controllers;

use App\Models\CV;
use App\Models\Experience;
use App\Models\Skill;
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

    public function save(Request $request)
    {
        $user = \Auth::user();
        $type = $request->get('type');
        $id = $request->get('id');

        //Summary
        $summary = $request->get('summary');

        //Experiences
        $business = $request->get('business');
        $description = $request->get('description');
        $startDate = $request->get('start_date');
        $finishDate = $request->get('finish_date');

        //Skills
        $name = $request->get('name');
        $value = $request->integer('value');


        if ($type === 'summary'){
             $user->cv()->update(['summary'=>$summary]);
             $newData = $summary;
        }
        else if($type === 'experience' and $id){

            $newData = Experience::findOrFail($id);
            $newData->business = $business;
            $newData->description = $description;
            $newData->start_date = $startDate;
            $newData->finish_date = $finishDate;
            $newData->save();

        } else if($type === 'experience' and !$id){
            $newData = $user->cv()->experiences()->create([
                'business'=>$business,
                'description'=>$description,
                'start_date'=>$startDate,
                'finish_date'=>$finishDate,
            ]);
        }else if($type === 'skill' and $id){

            $newData = Skill::findOrFail($id);
            $newData->name = $name;
            $newData->value = $value;
            $newData->save();

        }else if($type === 'skill' and !$id){
            $newData = $user->cv()->skills()->create([
                'name'=>$name,
                'value'=>$value,
            ]);
        }
        else{
            return response()->json([
                'message'=> "Something was wrong !",
            ],500);
        }

        $action = ($id ? 'updated' : 'created');
        $message = ucfirst($type)." has been successfully $action";

        return response()->json([
            'message'=> $message,
            'data'=>$newData,
            'type'=>$type
        ]);

    }
}
