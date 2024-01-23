<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    //get employee
    public function getEmployee(Request $request){
        if($request->role_id == 1){
            $employee = User::select('users.*', 'departments.title as department_name', 'roles.title as role')
                                ->leftJoin('departments','departments.id', 'users.department_id')
                                ->leftJoin('roles','roles.id', 'users.role_id')
                                ->get();
            for($i=0; $i<count($employee); $i++){
                if($employee[$i]->is_present == 1){
                $employee[$i]->is_present = 'Present';
            }else{
                $employee[$i]->is_present = 'Leave';
            }
            }
            return response()->json([
                'employeeData' => $employee,
                'message' => true
            ]);
        }else{
            return response()->json([
                'message' => false
            ]);
        }
    }

    //get Employee form Data
    public function getEmployeeFormData(){
        $departmentData = Department::get();
        $roleData = Role::get();

        return response()->json([
            'department' => $departmentData,
            'role' => $roleData
        ]);
    }

    //create employee
    public function createEmployee(Request $request){
        logger($request);
        $this->createValidation($request);
        $data = [
            'employee_id' => $request->employee_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'nrc' => $request->nrc,
            'address' => $request->address,
            'date_of_join' => $request->date_of_join,
            'gender' => $request->gender,
            'department_id' => $request->department_id,
            'role_id' => $request->role_id,
        ];

        User::create($data);
        $message = 'Employee successfully created!';
        $status = true;
        return response()->json([
            'message' => $message,
            'status' => $status
        ]);
    }


    //validate
    private function createValidation($request){
        Validator::make($request->all(), [
            'employee_id' => 'required',
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'required|min:9',
            'nrc' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'department_id' => 'required',
            'role_id' => 'required'

        ])->validate();
    }
}
