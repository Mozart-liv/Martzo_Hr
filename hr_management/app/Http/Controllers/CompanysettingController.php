<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Companysetting;
use Illuminate\Support\Facades\Validator;

class CompanysettingController extends Controller
{
    //get data
    public function getCompanyData(){
        $data = Companysetting::first();

        return response()->json($data);
    }

    //update
    public function updateCompany(Request $request){
        logger($request->all());
        $this->updateVal($request);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'office_start_time' => $request->office_start_time,
            'office_end_time' => $request->office_end_time,
            'break_start_time' => $request->break_start_time,
            'break_end_time' => $request->break_end_time,
        ];

        Companysetting::where('id', $request->id)->update($data);

        $message = 'Company setting successfully updated!';
        $status = true;
        return response()->json([
            'message' => $message,
            'status' => $status
        ]);
    }


    //update validation
    private function updateVal($request){
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required|min:9',
            'address' => 'required',
        ])->validate();
    }
}
