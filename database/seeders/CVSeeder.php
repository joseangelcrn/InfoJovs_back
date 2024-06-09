<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CVSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = User::with('cv')->get();
        $skills = [
            'php',
            'vue 2',
            'vue 3',
            'javascript',
            'java',
        ];

        foreach ($users as $key =>$user){
            if (!$user->cv){
                $cv = $user->cv()->create([
                    'summary'=>fake()->text()
                ]);

                foreach ($skills as $skill){
                    $cv->skills()->create([
                        'name'=>$skill,
                        'value'=>random_int(1,6),
                    ]);
                }

                $maxExperiences = 5;
                if ($key%2==0){
                    $maxExperiences = 6;
                }
                for($i=0;$i<=$maxExperiences;$i++){
                    $startDate = Carbon::parse(fake()->date());
                    $endDate = $startDate->copy();
                    $endDate->addYears(3);
                    $endDate->addMonths(3);

                    $cv->experiences()->create([
                        'business'=>fake()->text(5),
                        'description'=>fake()->sentence(),
                        'start_date'=>$startDate->format('Y-m-d'),
                        'finish_date'=>$endDate->format('Y-m-d')
                    ]);

                    if ($i === 6){
                        $cv->experiences()->create([
                            'business'=>fake()->text(5),
                            'description'=>fake()->sentence(),
                            'start_date'=>$startDate->format('Y-m-d'),
                        ]);
                    }
                }


            }
        }
    }
}
