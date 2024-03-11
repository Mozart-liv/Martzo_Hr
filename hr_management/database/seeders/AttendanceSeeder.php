<?php

namespace Database\Seeders;

use App\Models\CheckinCheckout;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = User::get();
        foreach($users as $user){
            $periods =new CarbonPeriod('2024-01-01', '2024-03-8');
            foreach($periods as $period){
                if($period->format('D') !== "Sat" && $period->format('D') !== "Sun"){
                    $data = [
                        'user_id' => $user->id,
                        'date' => $period->format('Y-m-d'),
                        'check_in' => Carbon::parse('09:00:00')->subMinutes(rand(1,55)),
                        'check_out' => Carbon::parse('17:00:00')->subMinutes(rand(1,55)),

                    ];

                    CheckinCheckout::create($data);

                }
            }
        }

    }
}
