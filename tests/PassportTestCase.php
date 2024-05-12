<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class PassportTestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions;

    protected $headers = [
        'Accept' => 'application/json'
    ];
    protected $scopes = [];
    public $role;
    public $user;

    /**
     * Create a fake user with espeicified role and generate a fake Bearer token..
     */
    public function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $user->assignRole($this->role);
        $this->user = $user;
        $token = $user->createToken('auth_token');
        $token = "Bearer $token->accessToken";
        $bearerTokenHeader = ['Authorization' => $token];

        $this->headers = array_merge($this->headers,$bearerTokenHeader);
        $this->withHeaders($this->headers);
    }

    public function setRole($roleName){
        $this->role = $roleName;
    }

}
