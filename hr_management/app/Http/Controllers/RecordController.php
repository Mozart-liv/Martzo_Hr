<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Salary;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Models\CheckinCheckout;

class RecordController extends Controller
{
     //get record for auth user
    public function getRecords($month, $year, $id){
        $records = CheckinCheckout::whereMonth('date', $month)->whereYear('date', $year)->where('user_id', $id)->orderBy('id', 'desc')->get();
        $startofMonth = Carbon::parse($year. '-'. $month . '-' . '01');
        $endofMonth = Carbon::parse($startofMonth)->endOfMonth()->format('Y-m-d');
        $periods = new CarbonPeriod($startofMonth, $endofMonth);
         $workingDays = 0;
        foreach($periods as $period){
             if($period->shortEnglishDayOfWeek !== 'Sat' && $period->shortEnglishDayOfWeek !== 'Sun'){
                $workingDays += 1;
            };
        }
        $salaries = Salary::where('month', $month)->where('year', $year)->where('user_id', $id)->first();


        $attendance = [];
        $attendForPayroll = [];
        $present = [];
        $absent = [];
            foreach($periods as $period){
                $att = CheckinCheckout::whereMonth('date', $month)->whereYear('date', $year)->where('user_id', $id)->where('date', $period)->first();

                if($att){
                    array_push($attendance, $att);
                    array_push($present, 'present');
                }else{
                   array_push($attendance, 'absent');
                   array_push($absent, 'absent');
                }

            }
            array_push($attendForPayroll, $present, $absent);



       return response()->json([
        'periods' => $periods,
        'attendance' => $attendance,
        'records' => $records,
        'workingDays' => $workingDays,
        'salaries' => $salaries,
        'attendForPayroll' => $attendForPayroll
       ]);
    }
}
