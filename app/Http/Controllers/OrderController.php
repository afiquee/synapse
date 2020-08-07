<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\State;
use App\Customer;
use App\Upload;
use App\Order;
use Illuminate\Support\Facades\Storage;
use App\Item;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;
use Illuminate\support\facades\URL;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Support\Str;



class OrderController extends Controller
{
    public $successCode = 200;
    public $errorCode = 400;
    public $keychain = "keychain";
    public $medal = "medal";
    public $lanyard = "lanyard";
    public $custom = "custom";

    public function index()
    {
        return view('order.order_list');
    }

    public function addOrder()
    {
        $states = State::all();
        return view('order.add_order')->with(compact('states'));
    }

    public function addOrderData(Request $request)
    {
        $user_id = Auth::user()->id;
        $customer = Customer::where('phone', $request->input('phone'))->first();

        if ($customer == null) {

            $cust_id = Customer::insertGetId([
                'phone'                  => $request->input('phone'),
                'name'                   => $request->input('name'),
                'email'                  => $request->input('email'),
                'address'                => $request->input('address'),
                'postcode'               => $request->input('postcode'),
                'city'                   => $request->input('city'),
                'created_by'             => $user_id,
                'created_at'             => now(),
            ]);
            $order_id = Order::insertGetId([
                'customer_id'            => $cust_id,
                'deadline'               => $request->input('deadline'),
                'payment_type'           => $request->input('payment_type'),
                'created_by'             => $user_id,
                'created_at'             => now(),
            ]);
        } else {
            $order_id = Order::insertGetId([
                'customer_id'            => $customer->id,
                'deadline'               => $request->input('deadline'),
                'payment_type'           => $request->input('payment_type'),
                'created_by'             => $user_id,
                'created_at'             => now(),
            ]);
        }

        if ($request->input("keychain_toggle") === "keychain") {

            $item_id = Item::insertGetId([
                'order_id'   => $order_id,
                'category'   => $request->input('keychain_toggle'),
                'type'       => $request->input('keychain_type'),
                'keyring'    => $request->input('keyring'),
                'heatpress'  => $request->input('heatpress'),
                'shape'      => $request->input('keychain_shape'),
                'quantity'   => $request->input('keychain_quantity'),
                'value'      => $request->input('keychain_value'),
                'created_by' => $user_id,
                'created_at' => now(),
            ]);

            if ($request->hasFile('keychain_files')) {
                $images = $request->file('keychain_files');

                foreach ($images as $image) {
                    $filename = $image->getClientOriginalName();
                    $extension = $image->getClientOriginalExtension();
                    $time = time();
                    $name = "$filename $time.$extension";
                    $destinationPath = public_path('images/FU');
                    $image->move($destinationPath, $name);
                    Upload::Create([
                        'item_id'                => $item_id,
                        'filename'               => $name,
                        'location'               => $destinationPath . $name,
                        'created_by'             => $user_id,
                        'created_at'             => now(),
                    ]);
                }
            }
        }

        if ($request->input("lanyard_toggle") === "lanyard") {
            Item::Create([
                'order_id'               => $order_id,
                'category'               => $request->input('lanyard_toggle'),
                'type'                   => $request->input('lanyard_type'),
                'quantity'               => $request->input('lanyard_quantity'),
                'value'                  => $request->input('lanyard_value'),
                'created_by'             => $user_id,
                'created_at'             => now(),
            ]);
        }

        if ($request->input("custom_toggle") === "custom") {
            Item::Create([
                'order_id'               => $order_id,
                'category'               => $request->input('custom_toggle'),
                'type'                   => $request->input('custom_type'),
                'quantity'               => $request->input('custom_quantity'),
                'value'                  => $request->input('custom_value'),
                'created_by'             => $user_id,
                'created_at'             => now(),
            ]);
        }
    }

    public function viewAll()
    {
        $orders = DB::table('ORDERS AS O')
            ->select('O.id as order_id', 'I.id as item_id', 'C.name as customer_name', 'deadline', 'category', 'value')
            ->join("CUSTOMERS AS C", 'C.id', '=', 'O.customer_id')
            ->join("ITEMS AS I", 'I.order_id', '=', 'O.id')
            ->get();

        $table     = '<table id="userTable" class="table table-striped table-bordered" style="width:100%" style="width:100%">';
        $table    .= '<thead>';
        $table    .= '<tr>';
        $table    .= '<th>Order ID</th>';
        $table    .= '<th>Item ID</th>';
        $table    .= '<th>Customer</th>';
        $table    .= '<th>Category</th>';
        $table    .= '<th>Value</th>';
        $table    .= '<th>Deadline</th>';
        $table    .= '<th>Action</th>';
        $table    .= '</thead>';
        $table    .= '</tr>';

        $table    .= '<tbody>';

        foreach ($orders as $order) {
            $table    .= '<tr>';
            $table    .= "<td>{$order->order_id}</td>";
            $table    .= "<td>{$order->item_id}</td>";
            $table    .= "<td>{$order->customer_name}</td>";
            $table    .= "<td>{$order->category}</td>";
            $table    .= "<td>{$order->value}</td>";
            $table    .= "<td>{$order->deadline}</td>";
            $table    .= '<td><div class="">';
            $table    .= "<a href='" . route('updateOrder', ['id' => $order->order_id]) . "' class'span-btn'><i class='fas fa-edit table-btn'></i></a>";
            $table    .= '<span id="deleteRowBtn" onclick="deleteRow(this)" data-id="' . $order->order_id . '" class="span-btn"><i class="fas fa-trash table-btn"></i></span>';
            $table    .= '</div>';
            $table    .= '</td>';
            $table    .= '</tr>';
        }
        $table    .= '</tbody>';
        $table    .= '</table>';

        return response()->json(
            [
                "status" => "success",
                "msg" => "Get orders successful",
                "data" => $table
            ]
        );
    }

    public function updateOrder(Request $request) {
        $id = $request->route('id');
        $order = Order::where('id',$id);
        $items = Order::where('order_id',$id);
        $states = State::all();
        return view('order.update_order')->with(compact('states', 'order', 'items'));
    }


}
