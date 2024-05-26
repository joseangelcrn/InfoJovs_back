<?php

namespace App\Libs;

class QuestionHelper
{
    public static function normalize($questions){

        //set value as null if not exists (if user ignored some question)
        $questions = array_map(function ($item){
            if (!isset($item['value']))
                $item['value'] = null;

            //remove 'edit' property if exists
            if (isset($item['answerOptions'])){
                $item['answerOptions'] = array_map(function ($item){
                    unset($item['edit']);
                    return $item;
                }, $item['answerOptions']);
            }
            return $item;
        }, $questions);


        return $questions;
    }
}
