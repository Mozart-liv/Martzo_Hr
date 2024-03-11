<?php

namespace App\Http\Controllers;

use App\Http\Requests\Department\DepartmentCreateRequest;
use App\Http\Requests\Department\DepartmentUpdateRequest;
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
    public function createDepartment(DepartmentCreateRequest $request){
        $request->validated();
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
    public function updateDepartment(DepartmentUpdateRequest $request){
        $request->validated();
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

        $message = 'Department deleted successfully!';
        return response()->json($message);
    }

}
