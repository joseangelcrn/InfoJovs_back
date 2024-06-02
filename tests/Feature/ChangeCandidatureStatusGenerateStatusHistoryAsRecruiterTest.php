<?php

namespace Tests\Feature;

use App\Libs\QuestionHelper;
use App\Models\Candidature;
use App\Models\CandidatureHistory;
use App\Models\CandidatureStatus;
use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\PassportTestCase;
use Tests\TestCase;

class ChangeCandidatureStatusGenerateStatusHistoryAsRecruiterTest extends PassportTestCase
{

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * A basic feature test example.
     */
    public function test_apply_candidature_as_employee_must_generate_a_history_entry(): void
    {
        parent::setRole('Employee');
        $job = Job::factory()->createOne();
        $params = [
            'job_id' => $job->id,
            'questions'=>[QuestionHelper::createFakeStructureWithResponses()]
        ];

        $response = $this->post(route('candidature.store'),$params);
        $response->assertStatus(200);

        $candidatureDb = Candidature::
            with('history')
              ->where('job_id', $job->id)
            ->where('employee_id',$this->user->id)
            ->first();

        $this->assertTrue($candidatureDb->status_id === 1);

        $historyDb = $candidatureDb->history;


        $this->assertTrue(count($historyDb) == 1);

        $historyDb =  $historyDb->first();

        $this->assertTrue($historyDb->origin_status_id === 1);
        $this->assertTrue($historyDb->destiny_status_id === 1);


    }

    public function test_recruiter_change_status_of_candidature_and_generate_an_history_entry(){

        parent::setRole('Recruiter');

        $job = Job::factory()->createOne();
        $job->recruiter_id = $this->user->id;
        $job->save();

        $employee = User::factory()->createOne();
        $employee->assignRole('Employee');

        $candidature =  $employee->candidatures()->create([
            'job_id'=>$job->id,
            'questions'=>json_encode(QuestionHelper::createFakeStructureWithResponses())
        ]);

        $newStatusId = CandidatureStatus::where('id','!=',1)->inRandomOrder()->first()->id;

        $params = [
            'candidature_ids'=>[$candidature->id],
            'status_id'=>$newStatusId,
        ];

        $response = $this->post(route('candidatureStatus.update'),$params);
        $response->assertStatus(200);

        $candidatureDb = Candidature::with('history')->find($candidature->id);
        $this->assertTrue($candidatureDb->status_id === $newStatusId);

        $lastHistory = $candidatureDb->history->sortByDesc('created_at')->first();

        $this->assertTrue($lastHistory->destiny_status_id === $newStatusId);

    }
}
