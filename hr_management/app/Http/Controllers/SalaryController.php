<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalaryController extends Controller
{
    //get salary list
    public function getSalaryList(){
        $salarys = Salary::select('salaries.*', 'users.name as name')
                            ->leftJoin('users', 'users.id', 'salaries.user_id')
                            ->get();

        return response()->json($salarys);
    }

    //get form data
    public function getFormData(){
        $employees = User::get();

        return response()->json([
            'employees' => $employees
        ]);
    }

    //create salary
    public function createSalary(Request $request){
        $this->Validation($request);
        $data = [
            'user_id' => $request->user_id,
            'year' => $request->year,
            'month' => $request->month,
            'amount' => $request->amount
        ];
        $check = Salary::where('user_id', $request->user_id)->where('year', $request->year)->where('month', $request->month)->first();
        if($check){
            $message = 'This Data is already recordes';
            $status = false;
        }else{
            Salary::create($data);

            $message = 'Salary added successfully';
            $status = true;
        }

        return response()->json([
            'message' => $message,
            'status' => $status
        ]);
    }

    //get update data
    public function getData($id){
        $data = Salary::where('id', $id)->first();
        return response()->json($data);
    }

    //update salary
    public function updateSalary(Request $request){
        $this->Validation($request);
        $data = [
            'user_id' => $request->user_id,
            'year' => $request->year,
            'month' => $request->month,
            'amount' => $request->amount
        ];

        $check = Salary::where('user_id', $request->user_id)->where('year', $request->year)->where('month', $request->month)->first();
        if($check){
            $message = 'This Data is already recordes';
            $status = false;
        }else{
            Salary::where('id', $request->id)->update($data);

            $message = 'Salary updated successfully!';
            $status = true;
        }

        return response()->json([
            'message' => $message,
            'status' => $status
        ]);

    }
    //delete
    public function deleteSalary($id){
        Salary::where('id', $id)->delete();

        $message = 'Salary deleted successfully!';
        return response()->json($message);
    }

    //validate
    private function Validation($request){
        Validator::make($request->all(), [
            'user_id' => 'required',
            'year' => 'required',
            'month' => 'required',
            'amount' => 'required',
        ])->validate();
    }
}
