<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\State;
use App\Customer;
use App\Order;
use App\Item;
use App\User;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public $successCode = 200;
    public $errorCode = 400;

    public function index() {
        return view('order.order_list');
    }

    public function addOrder() {

        $states = State::all();
        return view('order.add_order')->with(compact('states'));
    }

    public function orderData(Request $request) {

        $user_id = Auth::user()->id;
        //$customer_phone = Customer::where('phone', $request->input('phone'))->first();
        $customer = Customer::where('phone', $request->input('phone'))->first();

        // $input = $request->all();
        if($customer!=null){

            Order::Create([
                'customer_id'            => $customer->id,
                'deadline'               => $request->input('deadline'),
                'payment_type'           => $request->input('payment_type'),
                'created_by'             => $user_id,
                'created_at'             => now(),

            ]);
            // Item::Create($input);
            return response()->json(
                [
                    "status" => "success",
                    "msg" => "Register successful",
                ],
                $this->successCode);  
        }else{
            Customer::create([
                'phone'               => $request->input('phone'),
                'name'               => $request->input('name'),
                'email'           => $request->input('email'),
                'address'               => $request->input('address'),
                'postcode'           => $request->input('postcode'),
                'city'               => $request->input('city'),
                'created_by'             => $user_id,
                'created_at'             => now(),

            ]);
            Order::Create([
                'customer_id'            => $customer->id,
                'deadline'               => $request->input('deadline'),
                'payment_type'           => $request->input('payment_type'),
                'created_by'             => $user_id,
                'created_at'             => now(),

            ]);
            return response()->json(
                [
                    "status" => "success",
                    "msg" => "Register successful",
                ],
                $this->successCode);  

        }
         
        
        
    }
}
