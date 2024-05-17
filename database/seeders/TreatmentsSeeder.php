<?php

namespace Database\Seeders;

use App\Models\Treatment;
use App\Models\TreatmentClassification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TreatmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TreatmentClassification::factory(5)
            ->has(Treatment::factory(10))
            ->create();
    }
}
