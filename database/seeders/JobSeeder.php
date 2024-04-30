<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $recruiter = User::where('name', 'recruiter')->first();

        $data = [
            [
                'title' => 'Full-Stack developer (Laravel & Vue)',
                'description' => 'Cool description'
            ],
            [
                'title' => 'Junior Laravel developer',
                'description' => 'Cool description'
            ],
            [
                'title' => 'Middle Laravel developer',
                'description' => 'Cool description'
            ],
            [
                'title' => 'Senior Laravel developer',
                'description' => 'Cool description'
            ]
        ];


        $recruiter->jobsAsRecruiter()->createMany($data);
        $recruiter->jobsAsRecruiter()->createMany($data);
        $recruiter->jobsAsRecruiter()->createMany($data);
        $recruiter->jobsAsRecruiter()->createMany($data);
    }
}
