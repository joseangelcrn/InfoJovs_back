<?php

namespace Tests\Feature;

use App\Libs\QuestionHelper;
use App\Models\Job;
use App\Models\User;
use Tests\PassportTestCase;

class JobCrudTestAsRecruiterTest extends PassportTestCase
{

    public function setUp(): void
    {
        parent::setRole('Recruiter');
        parent::setUp();
    }


    /**
     * Recruiters Can...
     */

    public function test_can_create_job_as_recruiter(): void
    {
        $job = Job::factory()->make();
        $params = [
            'title'=>$job->title,
            'description'=>$job->description,
            'questions'=> QuestionHelper::createFakeStructure(),
            'tags'=>['php','vue']
        ];

        $response = $this->post(route('job.store'),$params);

        $response->assertStatus(200);
    }

    public function test_can_update_your_own_job_as_recruiter(): void
    {

        $job = Job::factory()->makeOne();
        $job->recruiter_id = $this->user->id;
        $job->save();

        $params = [
            'title'=>'Updated title',
            'description'=>'Updated description',
            'questions'=> QuestionHelper::createFakeStructure(),
            'tags'=>['php','vue'],
            'id'=>$job->id
        ];

        $response = $this->put(route('job.update',),$params);

        $response->assertStatus(200);
    }

    public function test_can_activate_your_own_job_as_recruiter(): void
    {
        $job = Job::factory()->createOne();
        $job->active = false;
        $job->recruiter_id = $this->user->id;
        $job->save();

        $params = [
            'id'=>$job->id,
            'active'=>true
        ];

        $response = $this->post(route('job.updateActive',),$params);

        $response->assertStatus(200);
    }
    public function test_can_deactivate_your_own_job_as_recruiter(): void
    {
        $job = Job::factory()->makeOne();
        $job->recruiter_id = $this->user->id;
        $job->active = true;
        $job->save();

        $params = [
            'id'=>$job->id,
            'active'=>false
        ];

        $response = $this->post(route('job.updateActive',),$params);

        $response->assertStatus(200);
    }



    /**
     * Recruiters Can Not...
     */

    public function test_can_not_update_other_job_as_recruiter(): void
    {
        $otherUser = User::factory()->createOne();
        $otherUser->assignRole('Recruiter');

        $job = Job::factory()->makeOne();
        $job->recruiter_id = $otherUser->id;
        $job->active = true;
        $job->save();

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


    public function test_can_not_activate_other_job_as_recruiter(): void
    {
        $otherUser = User::factory()->createOne();
        $otherUser->assignRole('Recruiter');

        $job = Job::factory()->makeOne();
        $job->recruiter_id = $otherUser->id;
        $job->active = true;
        $job->save();

        $params = [
            'id'=>$job->id,
            'active'=>false
        ];

        $response = $this->post(route('job.updateActive',),$params);

        $response->assertStatus(401);

    }

    public function test_can_not_deactivate_other_job_as_recruiter(): void
    {
        $otherUser = User::factory()->createOne();
        $otherUser->assignRole('Recruiter');

        $job = Job::factory()->makeOne();
        $job->recruiter_id = $otherUser->id;
        $job->active = false;
        $job->save();

        $params = [
            'id'=>$job->id,
            'active'=>true
        ];

        $response = $this->post(route('job.updateActive',),$params);

        $response->assertStatus(401);

    }



}
