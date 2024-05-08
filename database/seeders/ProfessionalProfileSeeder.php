<?php

namespace Database\Seeders;

use App\Models\ProfessionalProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Role;

class ProfessionalProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $employeeProfiles = [
            "Computer systems manager",
            "Network architect",
            "Systems analyst",
            "IT coordinator",
            "Network administrator",
            "Network engineer",
            "Service desk analyst",
            "System administrator (also known as sysadmin)",
            "Wireless network engineer",
            "Database administrator",
            "Database analyst",
            "Data quality manager",
            "Database report writer",
            "SQL database administrator",
            "Big data engineer/architect",
            "Business intelligence specialist/analyst",
            "Business systems analyst",
            "Data analyst",
            "Data analytics developer",
            "Data modeling analyst",
            "Data scientist",
            "Data warehouse manager",
            "Data warehouse programming specialist",
            "Intelligence specialist",
            "Back-end developer",
            "Cloud/software architect",
            "Cloud/software developer",
            "Cloud/software applications engineer",
            "Cloud system administrator",
            "Cloud system engineer",
            "DevOps engineer",
            "Front-end developer",
            "Full-stack developer",
            "Java developer",
            "Platform engineer",
            "Release manager",
            "Reliability engineer",
            "Software engineer",
            "Software quality assurance analyst",
            "UI (user interface) designer",
            "UX (user experience) designer",
            "Web developer",
            "Application security administrator",
            "Artificial intelligence security specialist",
            "Cloud security specialist",
            "Cybersecurity hardware engineer",
            "Cyberintelligence specialist",
            "Cryptographer",
            "Data privacy officer",
            "Digital forensics analyst",
            "IT security engineer",
            "Information assurance analyst",
            "Security systems administrator",
            "Help desk support specialist",
            "IT support specialist",
            "Customer service representative",
            "Technical product manager",
            "Product manager",
            "Project manager",
            "Program manager",
            "Portfolio manager",
//            "IT Recruiter",
//            "Recruiter"
        ];

        $employeRoleId = Role::where('name','employee')->first()->id;
        $recruiterRoleId = Role::where('name','recruiter')->first()->id;

        $dataEmployee = Arr::map($employeeProfiles,function ($profile) use($employeRoleId) {
            return [
                'title'=>$profile,
                'description'=>fake()->text,
                'role_id'=>$employeRoleId
            ];
        });

        $recruiterProfiles = [
            'Recruiter',
            'IT Recruiter',
            'HR Officer',
            'Recruitment Researcher',
            'Independent recruiting consultant',
            'Training technician',
            'Internal communication technician',
            'People connector',
            'Professional skills enhancer'
        ];
        $dataRecruiter = Arr::map($recruiterProfiles,function ($profile) use($recruiterRoleId) {
            return [
                'title'=>$profile,
                'description'=>fake()->text,
                'role_id'=>$recruiterRoleId
            ];
        });

        $data = array_merge($dataEmployee,$dataRecruiter);

        ProfessionalProfile::insert($data);

    }
}
