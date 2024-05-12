<?php

namespace Tests\Feature;

use Tests\PassportTestCase;
use function PHPUnit\Framework\assertTrue;

class RouteAccessesAsEmployeeTest extends PassportTestCase
{

    public function setUp(): void
    {
        parent::setRole('Employee');
        parent::setUp();
    }

    /**
     * A basic feature test example.
     */
    public function test_user_info_match_with_current_logged_user(): void
    {

        $response = $this->get("/api/user/info");

        $response->assertStatus(200);

        $data = $response->json();
        $data = json_decode(json_encode($data));

        $isEmployee = in_array('Employee',$data->roles);

        assertTrue($isEmployee,'User is an Employee');

        $isTheSameUser = $this->user->id === $data->user->id;

        assertTrue($isTheSameUser,"Logged User ID match with request user id");


    }
}
