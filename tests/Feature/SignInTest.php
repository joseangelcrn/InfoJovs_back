<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SignInTest extends TestCase
{

    use DatabaseTransactions;

    public function test_login_with_correct_credentials_must_success(): void
    {
        $user = User::factory()->createOne();
        $password = 'icanseethepassword';
        $user->password = bcrypt($password);
        $user->save();

        $response = $this->post('/api/login',[
            'email'=>$user->email,
            'password'=>$password
        ]);

        $response->assertStatus(200);
    }

    public function test_login_with_wrong_credentials_must_fail(): void
    {
        $user = User::factory()->createOne();
        $password = 'icanseethepassword';
        $user->password = bcrypt($password);
        $user->save();

        $response = $this->post('/api/login',[
            'email'=>$user->email,
            'password'=>$password.'addingwronginformation'
        ]);

        $response->assertStatus(401);
    }

    public function test_login_without_required_field_email_must_fail(): void{

        $user = User::factory()->createOne();
        $password = 'icanseethepassword';
        $user->password = bcrypt($password);
        $user->save();

        $response = $this->post('/api/login',[
            'password'=>$password
        ]);

        $response->assertBadRequest();
    }

    public function test_login_without_required_field_password_must_fail(): void{

        $user = User::factory()->createOne();
        $user->save();

        $response = $this->post('/api/login',[
            'email'=>$user->email
        ]);

        $response->assertBadRequest();
    }

}
