<?php

namespace Database\Seeders;

use App\Models\ProfessionalProfile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recruiter = User::create([
            'name'=>'Recruiter',
            'first_surname'=>'First surname',
            'second_surname'=>'Second surname',
            'email'=>'recruiter@gmail.com',
            'password'=>bcrypt('recruiter'),
            'professional_profile_id'=>ProfessionalProfile::where('title','it recruiter')->first()->id,
            'birth_date'=>fake()->dateTimeBetween('-30 years','-20 years')
        ]);


        $employee = User::create([
            'name'=>'Employee',
            'first_surname'=>'First surname',
            'second_surname'=>'Second surname',
            'email'=>'employee@gmail.com',
            'password'=>bcrypt('employee'),
            'professional_profile_id'=>ProfessionalProfile::where('title','Full-stack developer')->first()->id,
            'birth_date'=>fake()->dateTimeBetween('-30 years','-20 years')
        ]);

        //Assign roles

        $recruiter->assignRole('Recruiter');
        $employee->assignRole('Employee');

        //More Employees...
        $employees = User::factory()->createMany(100);
        foreach ($employees as $employee){
            $employee->assignRole('Employee');
        }
    }
}
