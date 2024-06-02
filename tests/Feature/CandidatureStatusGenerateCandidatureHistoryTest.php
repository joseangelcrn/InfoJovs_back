<?php

namespace Tests\Feature;

use App\Models\Candidature;
use App\Models\CandidatureStatus;
use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\PassportTestCase;
use Tests\TestCase;

class CandidatureStatusGenerateCandidatureHistoryTest extends PassportTestCase
{

    public function setUp(): void
    {
        parent::setRole('Recruiter');
        parent::setUp();
    }

    /**
     * @return array
     * Create all necessary data to test this module
     */
    public function generateData(){
        $job = Job::factory()->createOne();
        $employee = User::factory()->createOne();
        $employee->assignRole('Employee');
        $candidature = $job->candidatures()->create([
            'employee_id' => $employee->id
        ]);

        return [
            $job,$candidature,$employee
        ];
    }

    public function test_change_status_single_candidature(): void
    {
       [$job,$candidature,$employee] = $this->generateData();
       $statusId = CandidatureStatus::inRandomOrder()->first()->id;
       $params = [
            'candidature_ids'=>[$candidature->id],
           'status_id'=>$statusId
       ];
       $response = $this->post(route('candidatureStatus.update'),$params);

       $response->assertStatus(200);

       $candidatureFromDb = Candidature::find($candidature->id);
       $this->assertEquals($statusId,$candidatureFromDb->status_id);
    }


    public function test_change_status_many_candidatures(): void
    {
        $statusId = CandidatureStatus::inRandomOrder()->first()->id;
        $candidatures = collect();
        //for 3 times
        for ($i = 0; $i < 3; $i++) {
            [$job,$candidature,$employee] = $this->generateData();
            $candidatures->push($candidature);
        }

        $params = [
            'candidature_ids'=>$candidatures->pluck('id')->toArray(),
            'status_id'=>$statusId
        ];
        $response = $this->post(route('candidatureStatus.update'),$params);

        $response->assertStatus(200);

        $differentStatusIdOfExpected = Candidature::whereIn('id',$candidatures->pluck('id')->toArray())
            ->where('status_id','!=',$statusId)
            ->exists();

        $this->assertFalse($differentStatusIdOfExpected);
    }
}
