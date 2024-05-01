<?php

namespace Database\Seeders;

use App\Models\CandidatureStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidatureStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = [
            ['name' => 'Registered'],
            ['name' => 'Read CV'],
            ['name' => 'You continue in the selection process'],
            ['name' => 'Discarded'],
        ];

        CandidatureStatus::insert($data);
    }
}
