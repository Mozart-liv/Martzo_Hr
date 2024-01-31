<?php

namespace Database\Seeders;

use App\Models\Companysetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanyseetingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Companysetting::create([
            "name" => "Martzo co.ltd",
            "email" => "martzo@gmail.com",
            "phone" => "09123412345",
            "address" => "No(111), 2nd floor, Martzo Condo, Martzo street, Yangon",
            "office_start_time" => "09:00",
            "office_end_time" => "17:00",
            "break_start_time" => "12:00",
            "break_end_time" => "13:00"
        ]);
    }
}
