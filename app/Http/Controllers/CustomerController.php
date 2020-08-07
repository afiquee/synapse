<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function searchCustomer(Request $request) {

        $customer = $request->input('customer');
        $customers = DB::table("CUSTOMERS")
            ->select("id", DB::raw("CONCAT(phone, ' ', name) as label"))
            ->where(DB::raw("CONCAT(phone, '', name)"), "LIKE", "%$customer%")
            ->get();

        $output = "<ul id='list-group' class='list-group'>";
        foreach($customers as $c)
            $output.= "<li class='list-group-item' onclick='selectCustomer(this)' data-id='$c->id' >$c->label</li>"; 

        $output .= "</ul>";

        return response()->json(
            [
                "status" => "success",
                "msg"    => "Retrived customers successfully",
                "data"   => $output
            ]
        );        
    }

}
