<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
     //get department
    public function getDepartmentList(){
            $departments = Department::get();
            return response()->json([
                'departmentList' => $departments,
                'message' => true
            ]);
    }

    //create department
    public function createDepartment(Request $request){
        $this->Validation($request);
        $data = [
            'title' => $request->title
        ];
        Department::create($data);

        $message = 'Department successfully created!';
        $status = true;
        return response()->json([
            'message' => $message,
            'status' => $status
        ]);
    }

    //get update data
    public function getData($id){
        $data = Department::where('id', $id)->first();
        return response()->json($data);
    }

    //update data
    public function updateDepartment(Request $request){
        $this->updateValidation($request);
        $data = [
            'title' => $request->title
        ];

        if(Department::where('id', $request->id)->update($data)){
             $message = 'Department successfully updated!';
            $status = true;
        }else{
             $message = 'Department updated fail!';
            $status = false;
        }

        return response()->json([
            'message' => $message,
            'status' => $status
        ]);

    }

     //delete
    public function deleteDepartment($id){
        Department::where('id', $id)->delete();

        $message = 'Employee deleted successfully!';
        return response()->json($message);
    }

    //validate
    private function Validation($request){
        Validator::make($request->all(), [
            'title' => 'required|unique:departments,title'
        ])->validate();
    }

    //update validate
    private function updateValidation($request){
        Validator::make($request->all(), [
            'title' => 'required|unique:departments,title,' . $request->id
        ])->validate();
    }

}
