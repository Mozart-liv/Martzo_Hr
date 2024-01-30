<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //login
    public function login(Request $request){
        $this->loginVal($request);
        $user = User::where('email', $request->email)->first();

        if(isset($user)){
            if(Hash::check($request->password, $user->password)){
                return response()->json([
                    'user' => $user,
                    'status' => true,
                    'token' => $user->createToken(time())->plainTextToken
                ]);
            }else{
                return response()->json([
                    'user' => null,
                    'status' => false,
                    'message' => 'Password was wrong! '
                ]);
            }
        }else{
            return response()->json([
                    'user' => null,
                    'status' => false,
                    'message' => 'Does not have account with this email!'
                ]);
        }
    }

    //change password
    public function changePassword($id, Request $request){
        $this->passwordVal($request);
        $userData = User::where('id', $id)->first();
        $dbPsw = $userData->password;

        //check old password same db password
        if(Hash::check($request->oldpassword, $dbPsw)){
            $data = [
                'password' => Hash::make($request->newpassword)
            ];
            User::where('id', $id)->update($data);
            $message = null;
            $status = true;
        }else{
            $message = "Password wrong! try again...";
            $status = false;
        }
        return response()->json(['message' => $message, 'status' => $status]);
    }

    //validation password
    private function loginVal($request){
        Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ])->validate();
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
