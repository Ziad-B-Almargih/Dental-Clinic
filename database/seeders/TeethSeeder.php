<?php

namespace Database\Seeders;

use App\Models\Tooth;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeethSeeder extends Seeder
{
    private array $teeth = [
        'Central',
        'Lateral',
        'Cuspid',
        '1st Bicuspid',
        '2nd Bicuspid',
        '1st Molar',
        '2nd Molar',
        '3rd Molar',
    ];

    public function run(): void
    {
        for ($i = 1; $i <= 4; $i++) {
            $index = 1;
            foreach ($this->teeth as $tooth) {
                Tooth::query()
                    ->create([
                        'name' => $tooth,
                        'number' => 10 * $i + $index++,
                    ]);
            }
        }

    }
}
