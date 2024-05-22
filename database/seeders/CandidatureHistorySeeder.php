<?php

namespace Database\Seeders;

use App\Models\Candidature;
use App\Models\CandidatureHistory;
use App\Models\CandidatureStatus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidatureHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $candidatureStatuses = CandidatureStatus::all();
        $candidatures = Candidature::get();
        $recruiter = User::getRecruiter();
        $data = [];

        foreach ($candidatures as $candidature) {
            // 'Candidature creation'
            $candidatureCreationDate = Carbon::now()->subWeeks(3);
            $row = [
                'candidature_id' => $candidature->id,
                'recruiter_id' => $recruiter->id,
                'origin_status_id' => 1,
                'destiny_status_id' => 1,
                'created_at' => $candidatureCreationDate
            ];
            $data[] = $row;
            for ($i = 1; $i <= 4; $i++) {
                $randOriginStatus = $candidatureStatuses->random();
                $randDestinyStatus = $candidatureStatuses->where('id', '!=', $randOriginStatus->id)->random();
                $row = [
                    'candidature_id' => $candidature->id,
                    'recruiter_id' => $recruiter->id,
                    'origin_status_id' => $randOriginStatus->id,
                    'destiny_status_id' => $randDestinyStatus->id,
                    'created_at' => $candidatureCreationDate->copy()->addDays($i)
                ];
                $data[] = $row;
            }
        }

        //Applying inserts
        CandidatureHistory::insert($data);
    }
}
