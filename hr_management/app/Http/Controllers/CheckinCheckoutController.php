<?php

namespace App\Http\Controllers;

use App\Models\CheckinCheckout;
use Illuminate\Http\Request;

class CheckinCheckoutController extends Controller
{
    //
    public function check(Request $request){
        CheckinCheckout::firstOrCreate([
            'user_id' => $request->user_id,
            'date' => now()->format('Y-m-d'),
        ]);

        //check already checkin? if already checkin, do checkout. Or not,do checkin
        if(count(CheckinCheckout::where('user_id', $request->user_id)->where('date', now()->format('Y-m-d') )->whereNotNull('check_in')->get()->toArray()) == 0){
            CheckinCheckout::where('user_id', $request->user_id)->where('date', now()->format('Y-m-d') )->update(['check_in'=> now()]);
            $mes = 'checkin';
            $status = 'true';

        }elseif(count(CheckinCheckout::where('user_id', $request->user_id)->where('date', now()->format('Y-m-d') )->whereNotNull('check_out')->get()->toArray()) == 0){
             CheckinCheckout::where('user_id', $request->user_id)->where('date', now()->format('Y-m-d') )->update(['check_out'=> now()]);
            $mes = 'checkout';
            $status = 'true';
        }else{
            $mes = 'fail';
            $status = 'false';
        }

        logger($status);

        return response()->json(['mes' => $mes, 'status' => $status]);


    }

    //for check checkin or checkout when page reload
    public function checkattend($id){
        if(count(CheckinCheckout::where('user_id', $id)->where('date', now()->format('Y-m-d') )->whereNotNull('check_in')->get()->toArray()) > 0){
            $status = true;

        }elseif(count(CheckinCheckout::where('user_id', $id)->where('date', now()->format('Y-m-d') )->whereNotNull('check_out')->get()->toArray()) > 0){
            $status = false;
        }

        return response()->json($status);
    }
}
