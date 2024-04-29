<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        $table->id();
//        $table->string('name');
//        $table->string('first_surname');
//        $table->string('second_surname');
//        $table->string('email')->unique();
//        $table->timestamp('email_verified_at')->nullable();
//        $table->string('password');
//        $table->rememberToken();
//        $table->timestamps();
        $recruiter = User::create([
            'name'=>'Recruiter',
            'first_surname'=>'First surname',
            'second_surname'=>'Second surname',
            'email'=>'recruiter@gmail.com',
            'password'=>bcrypt('recruiter')
        ]);


        $employee = User::create([
            'name'=>'Employee',
            'first_surname'=>'First surname',
            'second_surname'=>'Second surname',
            'email'=>'employee@gmail.com',
            'password'=>bcrypt('employee')
        ]);

        //Assign roles

        $recruiter->assignRole('recruiter');
        $employee->assignRole('employee');
    }
}
