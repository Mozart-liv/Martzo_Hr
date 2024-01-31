<?php

namespace App\Http\Controllers;

use App\Models\CheckinCheckout;
use Illuminate\Http\Request;

class CheckinCheckoutController extends Controller
{
    //
    public function check(Request $request){
        if(count(CheckinCheckout::where('user_id', $request->user_id)->where('date' , now()->format('Y-m-d'))->whereNotNull('check_in')->whereNotNull('check_out')->get()) > 0){
            $status = false;
        }else{
            if($request->check == 'check_in'){
                CheckinCheckout::firstOrCreate([
                    'user_id' => $request->user_id,
                    'date' => now()->format('Y-m-d'),
                    'check_in' => now()
                ]);
            }else{
                CheckinCheckout::where('user_id', $request->user_id)->where('date' , now()->format('Y-m-d'))->update([
                    'check_out' => now()
                ]);
            }

            $status = true;
        }

        return response()->json($status);

    }
}
