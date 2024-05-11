<?php

namespace Tests\Feature;

use App\Models\ProfessionalProfile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SignUpTest extends TestCase
{
    use DatabaseTransactions;

    public function test_signup_without_existing_email_must_success()
    {

        $newUser = User::factory()->make();

        $role = Role::inRandomOrder()->first();
        $professionalProfile = ProfessionalProfile::where('role_id', $role->id)->inRandomOrder()->first();

        $response = $this->post('/api/signup', [
            'name' => $newUser->name,
            'first_surname' => $newUser->first_surname,
            'second_surname' => $newUser->second_surname,
            'email' => $newUser->email,
            'password' => $newUser->password,
            'role_id' => $role->id,
            'professional_profile_id' => $professionalProfile->id,
            'birthdate' => Carbon::parse($newUser->birth_date)->format('Y-m-d')
        ]);

        $response->assertStatus(200);

    }

    public function test_signup_with_existing_email_must_fail(){

        $existingUser = User::factory()->createOne();
        $newUser = User::factory()->make();

        $role = Role::inRandomOrder()->first();
        $professionalProfile = ProfessionalProfile::where('role_id', $role->id)->inRandomOrder()->first();

        $response = $this->post('/api/signup', [
            'name' => $newUser->name,
            'first_surname' => $newUser->first_surname,
            'second_surname' => $newUser->second_surname,
            'email' => $existingUser->email,
            'password' => $newUser->password,
            'role_id' => $role->id,
            'professional_profile_id' => $professionalProfile->id,
            'birthdate' => Carbon::parse($newUser->birth_date)->format('Y-m-d')
        ]);

        $response->assertBadRequest();
    }

}
