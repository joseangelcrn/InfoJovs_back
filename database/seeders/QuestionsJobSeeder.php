<?php

namespace Database\Seeders;

use App\Libs\QuestionHelper;
use App\Models\Candidature;
use App\Models\Job;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionsJobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobs = Job::all();
        $candidatures = Candidature::all();

        foreach ($jobs as $item) {
            if (!$item->questions){
                $questions = [];

                for ($i = 0;$i <3; $i++){
                    $questions[] = QuestionHelper::createFakeStructure();
                }

                $item->questions = $questions;
                $item->save();
            }
        }
        foreach ($candidatures as $item) {
            if (!$item->questions){
                $questions = [];

                for ($i = 0;$i <3; $i++){
                    $questions[] = QuestionHelper::createFakeStructureWithResponses();
                }

                $item->questions = $questions;
                $item->save();
            }
        }



    }
}
