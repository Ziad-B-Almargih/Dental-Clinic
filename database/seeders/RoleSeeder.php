<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    private array $roles = [
        'admin',
        'user'
    ];

    public function run(): void
    {
        foreach ($this->roles as $role){
            Role::query()->create([
                'role' => $role
            ]);
        }
    }
}
