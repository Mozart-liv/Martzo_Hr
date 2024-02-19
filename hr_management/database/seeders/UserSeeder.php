<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            "name" => "admin",
            "email" => "admin@gmail.com",
            "password" => Hash::make('admin1234'),
            "gender" => 'male',
            "phone" => '0987654345',
            "role_id" => 1,
            "department_id" => 1
        ]);

        User::create([
            "name" => "mai",
            "email" => "mai@gmail.com",
            "password" => Hash::make('mai1234'),
            "gender" => 'male',
            "phone" => '091234567',
            "role_id" => 2,
            "department_id" => 1
        ]);
    }
}
