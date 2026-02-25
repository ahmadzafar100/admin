<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::firstOrCreate(['name' => 'dashboard']);
        Permission::firstOrCreate(['name' => 'create categories']);
        Permission::firstOrCreate(['name' => 'edit categories']);
        Permission::firstOrCreate(['name' => 'delete categories']);
        Permission::firstOrCreate(['name' => 'create subcategories']);
        Permission::firstOrCreate(['name' => 'edit subcategories']);
        Permission::firstOrCreate(['name' => 'delete subcategories']);
        Permission::firstOrCreate(['name' => 'create news']);
        Permission::firstOrCreate(['name' => 'edit news']);
        Permission::firstOrCreate(['name' => 'delete news']);
    }
}
