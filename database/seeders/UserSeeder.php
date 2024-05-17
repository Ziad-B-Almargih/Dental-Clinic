<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use m2m\seeding\M2MSeeding;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        M2MSeeding::make(User::class, Permission::class, 'permissions');

        User::query()->create([
            'name'     => 'admin',
            'role_id'  => 1, // Admin role id is 1
            'email'    => env('ADMIN_EMAIL'),
            'password' => Hash::make(env('ADMIN_PASSWORD')),
        ]);


    }
}
