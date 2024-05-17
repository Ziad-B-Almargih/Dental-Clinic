<?php

namespace Database\Factories;

use App\Services\DatesServices;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Date>
 */
class DateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = $this->generateDate();
        while ((new DatesServices())->thereCollision($date['date'], $date['from'], $date['to']))
            $date = $this->generateDate();
        return [
            'date' => $date['date'],
            'from' => $date['from'],
            'to'   => $date['to'],
        ];
    }

    private function generateDate() : array {
        $date['date'] = (new Carbon('today'))->addDays(rand(-30, 30))->format('Y/m/d');
        $date['from'] = fake()->time('H:i');
        $date['to']   = (new Carbon($date['from']))->addMinutes(rand(10, 30))->format('H:i');
        return  $date;
    }
}
