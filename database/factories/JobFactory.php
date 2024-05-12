<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $recruiter = User::getRecruiter();
        if (!$recruiter){
            $newUser = User::factory()->createOne();
            $newUser->assignRole('Recruiter');
            $recruiter = $newUser;
        }

        return [
            'title'=>fake()->jobTitle,
            'description'=>fake()->text,
            'recruiter_id'=>$recruiter->id
        ];
    }
}
