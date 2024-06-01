<?php

namespace Tests\Feature;

use App\Libs\QuestionHelper;
use App\Models\Job;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\PassportTestCase;
use Tests\TestCase;

class JobCrudTestAsEmployeeTest extends PassportTestCase
{

    public function setUp(): void
    {
        parent::setRole('Employee');
        parent::setUp();
    }

    /**
     * Employees Can Not...
     */

    public function test_can_not_create_job_as_employee(): void
    {
        $job = Job::factory()->make();
        $params = [
            'title'=>$job->title,
            'description'=>$job->description,
            'questions'=> QuestionHelper::createFakeStructure(),
            'tags'=>['php','vue']
        ];

        $response = $this->post(route('job.store'),$params);

        $response->assertStatus(401);

    }


    public function test_can_not_update_job_as_employee(): void
    {
        $job = Job::factory()->createOne();
        $params = [
            'title'=>'Updated title',
            'description'=>'Updated description',
            'questions'=> QuestionHelper::createFakeStructure(),
            'tags'=>['php','vue'],
            'id'=>$job->id
        ];

        $response = $this->put(route('job.update',),$params);

        $response->assertStatus(401);
    }

    public function test_can_not_activate_job_as_employee(): void
    {

        $job = Job::factory()->createOne();
        $job->active = false;
        $job->save();

        $params = [
            'id'=>$job->id,
            'active'=>true
        ];

        $response = $this->post(route('job.updateActive',),$params);

        $response->assertStatus(401);
    }

    public function test_can_not_deactivate_job_as_employee(): void
    {

        $job = Job::factory()->createOne();
        $job->active = true;
        $job->save();

        $params = [
            'id'=>$job->id,
            'active'=>false
        ];

        $response = $this->post(route('job.updateActive',),$params);

        $response->assertStatus(401);
    }
}
