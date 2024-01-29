<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //Register
    public function register(Request $request){
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'password' => Hash::make($request->password)
        ];

        //check email unique
        if(count(User::where('email', $request->email)->get() ) > 0){
            $message = false;
        }else{
            User::create($data);
            $message = true;
        }

        return response()->json($message);
    }

    //login
    public function login(Request $request){
        $user = User::where('email', $request->email)->first();

        if(isset($user)){
            if(Hash::check($request->password, $user->password)){
                return response()->json([
                    'user' => $user,
                    'message' => true
                ]);
            }else{
                return response()->json([
                    'user' => null,
                    'message' => false
                ]);
            }
        }
    }

    //change password
    public function changePassword($id, Request $request){
        $this->passwordVal($request);
        $userData = User::where('id', $id)->first();
        $dbPsw = $userData->password;

        //check old password same db password
        if(Hash::check($request->oldpassword, $dbPsw)){
            $user = User::find($id);
            $user->password = Hash::make($request->newpassword);
            $message = "Password change Successfully!";
            $status = true;
        }else{
            $message = "Password wrong! try again...";
            $status = false;
        }
        return response()->json(['message' => $message, 'status' => $status]);
    }

     //password validation
    private function passwordVal($request){
        Validator::make($request->all(), [
            'oldpassword' => 'required|min:6',
            'newpassword' => 'required|min:6',
            'confirmpassword' => 'required|same:newpassword'
        ])->validate();
    }
}
