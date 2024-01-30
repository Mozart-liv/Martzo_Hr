<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
     //get role
    public function getRoleList(){
            $roles = Role::get();
            return response()->json([
                'roleList' => $roles,
                'message' => true
            ]);
    }

    //create role
    public function createrole(Request $request){
        $this->Validation($request);
        $data = [
            'title' => $request->title
        ];
        Role::create($data);

        $message = 'Role successfully created!';
        $status = true;
        return response()->json([
            'message' => $message,
            'status' => $status
        ]);
    }

    //get update data
    public function getData($id){
        $data = Role::where('id', $id)->first();
        return response()->json($data);
    }

    //update data
    public function updaterole(Request $request){
        $this->updateValidation($request);
        $data = [
            'title' => $request->title
        ];

        if(Role::where('id', $request->id)->update($data)){
             $message = 'Role successfully updated!';
            $status = true;
        }else{
             $message = 'Role update fail!';
            $status = false;
        }

        return response()->json([
            'message' => $message,
            'status' => $status
        ]);

    }

     //delete
    public function deleterole($id){
        Role::where('id', $id)->delete();

        $message = 'Employee deleted successfully!';
        return response()->json($message);
    }

    //validate
    private function Validation($request){
        Validator::make($request->all(), [
            'title' => 'required|unique:roles,title'
        ])->validate();
    }

    //update validate
    private function updateValidation($request){
        Validator::make($request->all(), [
            'title' => 'required|unique:roles,title,' . $request->id
        ])->validate();
    }
}
