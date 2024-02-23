<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Models\CheckinCheckout;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class CheckinCheckoutController extends Controller
{
    //
    public function check(Request $request){
        if(now()->format('D') == "Sat" || now()->format('D') == "Sun"){
            $mes = 'Today is OffDay!';
            $status = 'false';
        }else{
            CheckinCheckout::firstOrCreate([
            'user_id' => $request->user_id,
            'date' => now()->format('Y-m-d'),
        ]);

        //check already checkin? if already checkin, do checkout. Or not,do checkin

            if(count(CheckinCheckout::where('user_id', $request->user_id)->where('date', now()->format('Y-m-d') )->whereNotNull('check_in')->get()->toArray()) == 0){
            CheckinCheckout::where('user_id', $request->user_id)->where('date', now()->format('Y-m-d') )->update(['check_in'=> now()]);
            $mes = 'checkin';
            $status = 'true';

        }elseif(count(CheckinCheckout::where('user_id', $request->user_id)->where('date', now()->format('Y-m-d') )->whereNotNull('check_out')->get()->toArray()) == 0){
             CheckinCheckout::where('user_id', $request->user_id)->where('date', now()->format('Y-m-d') )->update(['check_out'=> now()]);
            $mes = 'checkout';
            $status = 'true';
        }else{
            $mes = 'Today attendance is already recorded!';
            $status = 'false';
        }
        }




        logger($status);

        return response()->json(['mes' => $mes, 'status' => $status]);


    }

    //for check checkin or checkout when page reload
    public function checkattend($id){
        if(count(CheckinCheckout::where('user_id', $id)->where('date', now()->format('Y-m-d') )->whereNotNull('check_in')->get()->toArray()) > 0){
            if(count(CheckinCheckout::where('user_id', $id)->where('date', now()->format('Y-m-d') )->whereNotNull('check_out')->get()->toArray()) > 0){
                $status = false;
            }else{
                $status = true;
            }
        }

        return response()->json($status);
    }

    //get attendance
    public function getAttendance(){
        $data = CheckinCheckout::select('checkin_checkouts.*', 'users.name as user')
                                ->leftJoin('users', 'users.id', 'checkin_checkouts.user_id')
                                ->orderBy('id', 'desc')
                                ->get();

        return response()->json($data);
    }

    //get data for create page
    public function getDataforCreatePage(){
        $employee = User::get();

        return response()->json($employee);
    }

    //create attendance
    public function createAttendance(Request $request){
        $this->validation($request);
        if(CheckinCheckout::where('user_id', $request->user_id)->where('date', $request->date)->exists()){
            $message = "Already record for this data";
            $status = false;
            return response()->json([
                'message' => $message,
                'status' => $status
            ]);
        }else{
            $data = [
                'user_id' => $request->user_id,
                'date' => $request->date,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
            ];
            CheckinCheckout::create($data);

            $message = "Attendance successfully created!";
            $status = true;
            return response()->json([
                'message' => $message,
                'status' => $status
            ]);
        }
    }

    //get update data
    public function getData($id){
        $data = CheckinCheckout::where('id', $id)->first();
        return response()->json($data);
    }

    //update attendance
    public function updateAttendance(Request $request){
        $this->validation($request);
        if(CheckinCheckout::where('user_id', $request->user_id)->where('date', $request->date)->where('id','!=', $request->id)->exists()){
            $message = "Already record for this data";
            $status = false;
            return response()->json([
                'message' => $message,
                'status' => $status
            ]);
        }else{
            $data = [
                'user_id' => $request->user_id,
                'date' => $request->date,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
            ];
            CheckinCheckout::where('id', $request->id)->update($data);

            $message = "Attendance successfully updated!";
            $status = true;
            return response()->json([
                'message' => $message,
                'status' => $status
            ]);
        }
    }

     //delete
    public function deleteAttendance($id){
        CheckinCheckout::where('id', $id)->delete();

        $message = 'Attendance deleted successfully!';
        return response()->json($message);
    }

    //get attendance overview
    public function attendanceOverview($month, $year){
        $startofMonth = Carbon::parse($year. '-'. $month . '-' . '01');
        $endofMonth = Carbon::parse($startofMonth)->endOfMonth()->format('Y-m-d');
        $periods = new CarbonPeriod($startofMonth, $endofMonth);
        $employees = User::get();
        $attendance = [];
        $all = [];
        foreach($employees as $employee){
            foreach($periods as $period){
                $att = CheckinCheckout::whereMonth('date', $month)->whereYear('date', $year)->where('user_id', $employee->id)->where('date', $period)->first();

                if($att){
                    array_push($attendance, $att);
                }else{
                   array_push($attendance, 'absent');
                }

            }

            array_push($all, $attendance);
            //clear attendance array
            $attendance = [];

        }


       return response()->json([
        'periods' => $periods,
        'employees' => $employees,
        'attendance' => $all
       ]);
    }

    //validation
    private function validation($request){
        Validator::make($request->all(), [
            'user_id' => 'required',
            'date' => 'required',
            'check_in' => 'required',
            'check_out' => 'required'
        ])->validate();
    }
}
