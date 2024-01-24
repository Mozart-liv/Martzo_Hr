<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    private $user = array();

    public function __construct()
    {
        $this->user = array(
            "name" => "WY",
            "email" => "wy@gmail.com",
            "password" => Hash::make('thepassword'),
            "gender" => 'male',
            "phone" => '0987654345',
        );
    }
    public function run(): void
    {
        User::insert([$this->user]);
    }
}
