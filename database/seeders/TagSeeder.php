<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $jobs = Job::all();
        $tags = collect([
            'php',
            'vuejs',
            'vue-2',
            'vue-3',
            'javascript',
            'html',
            'css',
            'python'
        ]);

        foreach ($jobs as $job){
            foreach ($tags->random(3) as $tag){
                $job->tags()->create(['name'=>$tag]);
            }
        }
    }
}
