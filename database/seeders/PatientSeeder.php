<?php

namespace Database\Seeders;

use App\Models\Disease;
use App\Models\Operation;
use App\Models\Patient;
use App\Models\Treatment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use m2m\seeding\M2MSeeding;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Patient::factory(10)->create();

        M2MSeeding::make(Patient::class, Disease::class, 'diseases')->run();

        Operation::factory(100)->create();
    }
}
