<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
     
    public function run(): void
    {
        $roles = ['CUSTOMER', 'AUDITOR', 'SUPPORT_AGENT', 'BANK_ADMIN'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
