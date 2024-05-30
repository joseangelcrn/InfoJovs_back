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
}
