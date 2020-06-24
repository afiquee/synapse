<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\State;
use App\Customer;
use App\Order;
use Illuminate\Support\Facades\Storage;
use App\Item;
use App\User;
use Illuminate\Support\Facades\Auth;
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
    public $keychain ="keychain";
    public $medal ="medal";
    public $lanyard ="lanyard";
    public $custom ="custom";

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
            // $image = $request->file('files');
            // $name = $customer->id . '.' .$image->getClientOriginalExtension();
            // $destinationPath = public_path('images/FU');
            // $image->move($destinationPath,$name);
            
            // $path = $request->file('file')->store('image/data');
            // console.log($path);

       
            
            $order = Order::where('payment_type', $request->input('payment_type'))->first();
            // $this->validate($request,[
            //     'file' =>'required|image|mimes:jpeg,png,svg,jpg,gif|max:2048', 
            // ]);
            if($request->input("keychain_toggle") === "keychain"){
                
                Item::Create([
                    'order_id'               => $order->id,
                    'category'               => $request->input('keychain_toggle'),
                    'type'                   => $request->input('keychain_type'),
                    'keyring'                => $request->input('keyring'),
                    'heatpress'              => $request->input('heatpress'),
                    'shape'                  => $request->input('keychain_shape'),
                    'quantity'               => $request->input('keychain_quantity'),
                    'value'                  => $request->input('keychain_value'),
                    //'tracking_no'            => $request->input('trackingnumber'),
                    // 'fileupload'             => $name,
                    'created_by'             => $user_id,
                    'created_at'             => now(),
                ]);
                // $items = Item::where('category', $request->input('keychain_toggle'))->first();
                // if($request->hasFile('keychain_files')){
                //     $image = $request->file('keychain_files');
                //     foreach($image as $photo){
                //     $name = $customer->id . '.' .$photo->getClientOriginalExtension();
                //     $destinationPath = public_path('images/FU');
                //     $image->move($destinationPath,$name);
                //     }
                //     $items->fileupload =$name;
                //     $items->save();
                // }
                $fileName = time().'.'.$request->file->extension();  
                $request->file->move(public_path('uploads'), $fileName);
   

            }if($request->input("medal_toggle") === "medal"){
                Item::Create([
                    'order_id'               => $order->id,
                    'category'               => $request->input('medal_toggle'),
                    'type'                   => $request->input('medal_type'),
                    'quantity'               => $request->input('medal_quantity'),
                    'value'                  => $request->input('medal_value'),
                        //'tracking_no'            => $request->input('trackingnumber'),
                        // 'fileupload'             => $fileName,
                    'created_by'             => $user_id,
                    'created_at'             => now(),
                    ]);
            }if($request->input("lanyard_toggle") === "lanyard"){
                Item::Create([
                    'order_id'               => $order->id,
                    'category'               => $request->input('lanyard_toggle'),
                    'type'                   => $request->input('lanyard_type'),
                    'quantity'               => $request->input('lanyard_quantity'),
                    'value'                  => $request->input('lanyard_value'),
                        //'tracking_no'            => $request->input('trackingnumber'),
                        // 'fileupload'             => $fileName,
                    'created_by'             => $user_id,
                    'created_at'             => now(),
                    ]);
            }if($request->input("custom_toggle") === "custom"){
                Item::Create([
                    'order_id'               => $order->id,
                    'category'               => $request->input('custom_toggle'),
                    'type'                   => $request->input('custom_type'),
                    'quantity'               => $request->input('custom_quantity'),
                    'value'                  => $request->input('custom_value'),
                        //'tracking_no'            => $request->input('trackingnumber'),
                        // 'fileupload'             => $fileName,
                    'created_by'             => $user_id,
                    'created_at'             => now(),
                    ]);
            }
                
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
            $customer = Customer::where('phone', $request->input('phone'))->first();
            Order::Create([
                'customer_id'            => $customer->id,
                'deadline'               => $request->input('deadline'),
                'payment_type'           => $request->input('payment_type'),
                'created_by'             => $user_id,
                'created_at'             => now(),

            ]);
            $order = Order::where('payment_type', $request->input('payment_type'))->first();
            if($request->input("keychain_toggle") === "keychain"){
                Item::Create([
                    'order_id'               => $order->id,
                    'category'               => $request->input('keychain_toggle'),
                    'type'                   => $request->input('keychain_type'),
                    'keyring'                => $request->input('keyring'),
                    'heatpress'              => $request->input('heatpress'),
                    'shape'                  => $request->input('keychain_shape'),
                    'quantity'               => $request->input('keychain_quantity'),
                    'value'                  => $request->input('keychain_value'),
                    //'tracking_no'            => $request->input('trackingnumber'),
                    // 'fileupload'             => $fileName,
                    'created_by'             => $user_id,
                    'created_at'             => now(),
                ]);
            }if($request->input("medal_toggle") === "medal"){
                Item::Create([
                    'order_id'               => $order->id,
                    'category'               => $request->input('medal_toggle'),
                    'type'                   => $request->input('medal_type'),
                    'quantity'               => $request->input('medal_quantity'),
                    'value'                  => $request->input('medal_value'),
                        //'tracking_no'            => $request->input('trackingnumber'),
                        // 'fileupload'             => $fileName,
                    'created_by'             => $user_id,
                    'created_at'             => now(),
                    ]);
            }if($request->input("lanyard_toggle") === "lanyard"){
                Item::Create([
                    'order_id'               => $order->id,
                    'category'               => $request->input('lanyard_toggle'),
                    'type'                   => $request->input('lanyard_type'),
                    'quantity'               => $request->input('lanyard_quantity'),
                    'value'                  => $request->input('lanyard_value'),
                        //'tracking_no'            => $request->input('trackingnumber'),
                        // 'fileupload'             => $fileName,
                    'created_by'             => $user_id,
                    'created_at'             => now(),
                    ]);
            }if($request->input("custom_toggle") === "custom"){
                Item::Create([
                    'order_id'               => $order->id,
                    'category'               => $request->input('custom_toggle'),
                    'type'                   => $request->input('custom_type'),
                    'quantity'               => $request->input('custom_quantity'),
                    'value'                  => $request->input('custom_value'),
                        //'tracking_no'            => $request->input('trackingnumber'),
                        // 'fileupload'             => $fileName,
                    'created_by'             => $user_id,
                    'created_at'             => now(),
                    ]);
            }
            return response()->json(
                [
                    "status" => "success",
                    "msg" => "Register successful",
                ],
                $this->successCode);  
        }
    }
}
