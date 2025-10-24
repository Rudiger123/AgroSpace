<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => 'producer']);
        Role::create(['name' => 'consumer']);
        Role::create(['name' => 'admin']);
    }
}
