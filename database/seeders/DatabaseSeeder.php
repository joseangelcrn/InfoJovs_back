<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            RoleSeeder::class, //Required
            ProfessionalProfileSeeder::class, //Required
            UserSeeder::class,
            JobSeeder::class,
            CandidatureStatusSeeder::class, //Required
            CandidatureSeeder::class,
            TagSeeder::class,
            CandidatureHistorySeeder::class
        ]);
    }
}
