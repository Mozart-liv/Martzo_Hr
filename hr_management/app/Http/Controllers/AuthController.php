<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Hash;

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


}
