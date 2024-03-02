<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    //get employee
    public function getEmployeeList(){
            $employee = User::select('users.*', 'departments.title as department_name', 'roles.title as role')
                                ->leftJoin('departments','departments.id', 'users.department_id')
                                ->leftJoin('roles','roles.id', 'users.role_id')
                                ->get();
            return response()->json([
                'employeeData' => $employee,
                'message' => true
            ]);
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
        $this->Validation($request);
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

        if($request->hasFile('img')){
            $file = $request->file('img');
            $fileName = uniqid() . '_' . $file->getClientOriginalName();
            $file->move(public_path('image'), $fileName);
            $data['img'] = $fileName;
        }
        User::create($data);

        $message = 'Employee successfully created!';
        $status = true;
        return response()->json([
            'message' => $message,
            'status' => $status
        ]);
    }

    //get update user data
    public function getUserData($id){
        $data = User::select('users.*', 'departments.title as department_name', 'roles.title as role')
                                ->leftJoin('departments','departments.id', 'users.department_id')
                                ->leftJoin('roles','roles.id', 'users.role_id')
                                ->where('users.id', $id)->first();
        return response()->json($data);
    }

    //update data
    public function updateEmployee(Request $request){
        $this->updateVal($request, $request->id);
        $data = [
            'employee_id' => $request->employee_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'nrc' => $request->nrc,
            'address' => $request->address,
            'date_of_join' => $request->date_of_join,
            'gender' => $request->gender,
            'department_id' => $request->department_id,
            'role_id' => $request->role_id,
            'is_present' => $request->is_present
        ];

         if($request->hasFile('img')){
            //delete old data
            $oldData = User::where('id', $request->id)->first();
            $oldImg = $oldData['img'];
            File::delete(public_path() . '/image/'. $oldImg);

            //update
            $file = $request->file('img');
            $fileName = uniqid() . '_' . $file->getClientOriginalName();
            $file->move(public_path('image'), $fileName);

            $data['img'] = $fileName;
        }

        if(User::where('id', $request->id)->update($data)){
             $message = 'Employee successfully updated!';
            $status = true;
        }else{
             $message = 'Employee fail updated!';
            $status = false;
        }

        return response()->json([
            'message' => $message,
            'status' => $status
        ]);

    }

    //delete
    public function deleteEmployee($id){
        $dbData = User::where('id', $id)->first();
        $dbimg = $dbData['img'];

        User::where('id', $id)->delete();
        if(File::exists(public_path() . '/image/'. $dbimg)){
            File::delete(public_path() . '/image/'. $dbimg);
        }

        $message = 'Employee deleted successfully!';
        return response()->json($message);
    }

    //validate
    private function Validation($request){
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'required|min:9',
            'nrc' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'department_id' => 'required',
            'date_of_join' => 'required',
            'role_id' => 'required'

        ])->validate();
    }

    //update validation
    private function updateVal($request, $id){
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'phone' => 'required|min:9',
            'nrc' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'department_id' => 'required',
            'role_id' => 'required'

        ])->validate();
    }
}
