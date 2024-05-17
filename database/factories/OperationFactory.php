<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\Tooth;
use App\Models\Treatment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Operation>
 */
class OperationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $teethCount = Tooth::query()->count();
        $patientCount = Patient::query()->count();
        $treatmentCount = Treatment::query()->count();
        return [
            'tooth_id' => rand(1, $teethCount),
            'patient_id' => rand(1, $patientCount),
            'treatment_id' => rand(1, $treatmentCount),
            'type' => 'treatments',
        ];
    }
}
