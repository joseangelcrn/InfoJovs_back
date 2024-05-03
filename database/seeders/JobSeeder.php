<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $recruiter = User::where('name', 'recruiter')->first();
        $desc = "The Role

We are looking for a PHP Developer to join our fast-growing team and assist in the drive of the company's growth.

What You'll Do

Translate business requirements into technical deliverables.
Develop additional features on existing applications.
Take ownership of work and see it all the way through the software development life cycle.
Investigate and resolve defects in the established system.
Help define non-functional requirements and build systems capable of meeting them.
Deliver operationally stable software and help ensure uptime.
Build processes to provide an excellent customer experience.
Improve automation of our CICD processes.
Deliver API enabled components and microservices.
Be part of a distributed Agile team and contribute to its success and improvement.
Mentor junior members of the team.
Design and implement solution architecture to meet functional and non-functional requirements.

You'll Bring

Master's in Computer Science with at least four (4) to six (6) years of commercial experience.
Full professional proficiency in English.
Excellent communication and inter-personal skills.
Extensive experience developing PHP applications and hands-on experience working with at least one of its mainstream frameworks (e.g. Laravel, CodeIgniter, Symfony, Yii2, Phalcon or Zend)
Proficient with Agile methodologies, CI, TDD/BDD, SQL/NoSQL databases and REST/SOAP webservices.
Hands on experience with legacy PHP frameworks (Qcubed).
Hands on experience with modern PHP frameworks (Laravel).
Experience within a microservices / DevOps environment (Docker, Kubernetes).
A can-do, problem-solving attitude & work well as part of a team.
Experience mentoring developers.

Labor Conditions

Place of Work: Alcobendas, Madrid, Spain / Sevilla
Type of Contract: Indefinite Term.
Salary: Negotiable based on experience.";



        $data = [
            [
                'title' => 'Full-Stack developer (Laravel & Vue)',
                'description' => $desc
            ],
            [
                'title' => 'Junior Laravel developer',
                'description' => $desc
            ],
            [
                'title' => 'Middle Laravel developer',
                'description' => $desc
            ],
            [
                'title' => 'Senior Laravel developer',
                'description' => $desc
            ]
        ];


        for ($i = 0;$i<4;$i++){
            $recruiter->jobsAsRecruiter()->createMany($data);
        }
    }
}
