<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(['name' => 'Superadmin', 'email' => 'ahmadzafar100@gmail.com', 'email_verified' => 1, 'mobile' => '9616251187', 'mobile_verified' => 1, 'username' => 'superadmin', 'password' => Hash::make('admin'), 'role_id' => 1]);
    }
}
