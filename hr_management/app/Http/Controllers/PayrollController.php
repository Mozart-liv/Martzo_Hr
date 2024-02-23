<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Models\CheckinCheckout;
use App\Models\Salary;

class PayrollController extends Controller
{
    //get attendance overview
    public function getPayroll($month, $year){
        $startofMonth = Carbon::parse($year. '-'. $month . '-' . '01');
        $endofMonth = Carbon::parse($startofMonth)->endOfMonth()->format('Y-m-d');
        $periods = new CarbonPeriod($startofMonth, $endofMonth);
        $workingDays = 0;
        foreach($periods as $period){
            logger($period->shortEnglishDayOfWeek);
             if($period->shortEnglishDayOfWeek !== 'Sat' && $period->shortEnglishDayOfWeek !== 'Sun'){
                $workingDays += 1;
            };
        }
        $employees = User::select('users.*', 'roles.title as role')
                                ->leftJoin('roles','roles.id', 'users.role_id')
                                ->get();
        $salaries = Salary::where('month', $month)->where('year', $year)->get();
        $present = [];
        $absent = [];
        $attendance = [];
        $all =[];
        foreach($employees as $employee){
            foreach($periods as $period){
                $att = CheckinCheckout::whereMonth('date', $month)->whereYear('date', $year)->where('user_id', $employee->id)->where('date', $period)->first();

                if($att){
                    array_push($present, $att);
                }else{
                   array_push($absent, 'absent');
                }

            }
            array_push($attendance,  $present, $absent);
            array_push($all, $attendance);
            //clear attendance arrays
            $attendance = [];
            $present = [];
            $absent = [];

        }


       return response()->json([
        'periods' => $periods,
        'employees' => $employees,
        'attendance' => $all,
        'workingDays' => $workingDays,
        'salaries' => $salaries
       ]);
    }
}
