<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    private array $permissions = [
        'dates-create',
        'dates-delete',
        'diseases-create',
        'diseases-update',
        'diseases-delete',
        'treatment-classifications-create',
        'treatment-classifications-update',
        'treatments-create',
        'treatments-update',
        'treatments-delete',
        'patients-show-index',
        'patients-show',
        'patients-create',
        'payments-create',
        'payments-update',
        'payments-delete',
        'debts-show',
    ];
    public function run(): void
    {
        foreach ($this->permissions as $permission){
            Permission::query()
                ->create([
                    'type' => $permission
                ]);
        }
    }
}
