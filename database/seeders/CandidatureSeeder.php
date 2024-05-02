<?php

namespace Database\Seeders;

use App\Models\Candidature;
use App\Models\CandidatureStatus;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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

    }
}
