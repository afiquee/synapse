<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\State;
use App\Customer;
use App\Order;
use App\Item;
use App\User;

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

        $input = $request->all(); 
        Customer::create($input);
        Order::Create($input);
        // Item::Create($input);
        return response()->json(
            [
                "status" => "success",
                "msg" => "Register successful",
            ],
            $this->successCode);  
    }
}
