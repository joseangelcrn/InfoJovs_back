<?php

namespace App\Libs;

class QuestionHelper
{
    public static function normalize($questions,$options = []){

        //set value as null if not exists (if user ignored some question)
        $questions = array_map(function ($item) use($options){
            if (!isset($item['value'])){
                $item['value'] = null;
            }
//
//            if ($item['type'] == 'options' and $item['value']){
//                $item['value'] = intval($item['value']);
//            }

            //remove 'edit' property if exists and if is required by 'options'
            if (in_array('remove_edit',$options) and isset($item['answerOptions'])){
                $item['answerOptions'] = array_map(function ($item){
                    unset($item['edit']);
                    return $item;
                }, $item['answerOptions']);
            }
            return $item;
        }, $questions);


        return $questions;
    }

    /**
     * @return array
     *
     * Function to create fake question structure
     */
    public static function createFakeStructure(){
        $types = ['free','options'];


        $type = $types[array_rand($types)];
        $title = fake()->sentence(8)." ?";

        $question['type'] = $type;
        $question['title'] = $title;

        if ($type == "options"){
            $answerOptions = [];
            for ($i = 0; $i< 3; $i++){
                $answerOptions[] = [
                    "edit" => false,
                    "text" => "Option ".($i+1),
                ];
            }
            $question['answerOptions'] = $answerOptions;
        }

        return $question;
    }

    public static function createFakeStructureWithResponses(){

        $question = self::createFakeStructure();
        $value = null;
        if ($question['type'] == "free"){
            $value = fake()->sentence;
        }
        else if ($question['type'] == "options"){
            $nOptions = count($question['answerOptions']);
            $value = rand(0, $nOptions);
        }


        $question['value'] =$value;

        return $question;
    }
}
