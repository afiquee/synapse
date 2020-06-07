<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\State;

class OrderController extends Controller
{
    public function index() {
        return view('order.order_list');
    }

    public function addOrder() {

        $states = State::all();
        return view('order.add_order')->with(compact('states'));
    }
}
