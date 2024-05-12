<?php

namespace Database\Seeders;

use App\Models\Candidature;
use App\Models\CandidatureStatus;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class CandidatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $amount = 8;
        $randomJobs = Job::inRandomOrder()->take($amount)->get();
        $employee = User::getEmployee();

        $data = $randomJobs->map(function($item,$index) use ($employee){
            return ['job_id'=>$item->id,'employee_id'=>$employee->id,'status_id'=>CandidatureStatus::inRandomOrder()->first()->id];
        })->toArray();


       Candidature::insert($data);


       //More Candidatures...

        $amount = 30;
        $jobs = Job::select('id')->get();
        $statuses = CandidatureStatus::all();

        foreach ($jobs as $job){
            $employees = User::inRandomOrder()
                ->whereHas('roles',function ($q){
                    return $q->where('roles.name','Employee');
                })
                ->take($amount)->get();
            foreach ($employees as $employee){
                Log::debug('employee profile id = '.$employee->professional_profile_id);
                Log::debug('job id  = '.$job->id);

                $employee->candidatures()->create(['job_id'=>$job->id,'status_id'=>$statuses->random()->id,'created_at'=>fake()->dateTimeBetween('-14 days')]);
            }
        }
    }
}
