<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;

class CustomerController extends Controller
{
    public function showAll() {

    }

    public function getCustomerByPhone(Request $request) {

        $request->validate([
            'phone' => 'required',
        ]);

        $customer = Customer::where('phone', $request->input('phone'))->first();
        $msg = $customer ? 'customer found' : 'customer not found';

        return response()->json(
            [
                "status" => "success",
                "msg"    => $msg,
                "data"   => $customer
            ]
        );        


    }

}
