<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'berth_date' => fake()->date,
            'phone_number' => '09'.rand(10000000, 99999999),
            'gender' => rand(0,1),
            'note' => fake()->text,
            'prescription' => fake()->text
        ];
    }
}
