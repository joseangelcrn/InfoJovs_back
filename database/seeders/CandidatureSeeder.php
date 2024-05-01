<?php

namespace Database\Seeders;

use App\Models\Candidature;
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
        $randomJobs = Job::inRandomOrder()->take(3)->get();
        $employee = User::getEmployee();

        $data = $randomJobs->map(function($item) use ($employee){
            return ['job_id'=>$item->id,'employee_id'=>$employee->id];
        })->toArray();


       Candidature::insert($data);

    }
}
