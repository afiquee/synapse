<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index() {
        return view('order.order_list');
    }

    public function addOrder() {
        return view('order.add_order');
    }
}
