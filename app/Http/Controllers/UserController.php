<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Response;
use Session;
use DB;

class UserController extends Controller
{
    public $successCode = 200;
    public $errorCode = 400;

    public function index() {
        return view('user.user');
    }

    public function profile() {
        return view('user.profile');
    }

    public function login(Request $request) {

        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('home');
        }

        return Redirect::back()->withErrors('Invalid login credentials')->withInput();

    }

    public function register(Request $request) {

        $validator = Validator::make(
            $request->all(), 
            [    
                'name'  => 'required',
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    "status" => "failed",
                    "msg"    => $validator->errors()
                ], 
                $this->errorCode);
        }

        $input = $request->all(); 
        $input['password'] = bcrypt('password123'); 
        User::create($input);
        return response()->json(
            [
                "status" => "success",
                "msg" => "Get users successful",
            ],
            $this->successCode);     
    }

    public function update(Request $request) {

        $input = $request->all(); 
        $input['password'] = bcrypt('password123'); 
        $input = User::where('id',$request->input('u_id'))->update
            ([
            'name'             => $request->input('u_name'),
            'email'            => $request->input('u_email'),
            'role'             => $request->input('u_role'),
            ]);
        return response()->json(
            [
                "status" => "success",
                "msg" => "Register successful",
            ],
            $this->successCode);     
    }

    public function editprofile(Request $request){
        
        $validator = Validator::make(
            $request->all(),
            [
                'old_password' => ['required', new MatchOldPassword],
                'password1' => ['required'],
                'password2' => ['same:password1'],
            ],
        );
        if ($validator->fails()) {
            return response()->json(
                [
                    "status" => "failed",
                    "msg"    => $validator->errors()
                ], 
                $this->errorCode);
        }

        User::find(auth()->user()->id)->update
        ([
            'password'=> Hash::make($request->input('password1')),
        ]);
        return response()->json(
            [
                "status" => "success",
                "msg" => "Register successful",
            ],
            $this->successCode);
    }

    public function delete(Request $request) {
        $request->all();
        User::where('id',$request->input('id'))->delete();
        return response()->json(
            [
                "status" => "success",
                "msg" => "Register successful",
            ],
            $this->successCode);     
    }

    public function viewAll() {
        $users = User::All();

        $table     = '<table id="userTable" class="table table-striped table-bordered" style="width:100%" style="width:100%">';
        $table    .= '<thead>';
        $table    .= '<tr>';
        $table    .= '<th>ID</th>';
        $table    .= '<th>Email</th>';
        $table    .= '<th>Name</th>';
        $table    .= '<th>Role</th>';
        $table    .= '<th>Action</th>';
        $table    .= '</thead>';
        $table    .= '</tr>';

        $table    .= '<tbody>';
        foreach($users as $user){
            $table    .= '<tr>';
            $table    .= "<td>{$user['id']}</td>";
            $table    .= "<td>{$user['email']}</td>";
            $table    .= "<td>{$user['name']}</td>";
            $table    .= "<td>{$user['role']}</td>";
            $table    .= '<td><div class="">';
            $table    .= '<span id="updateRowBtn" onclick="updateRow(this)"  data-id="'.$user['id'].'" data-email="'.$user['email'].'" data-name="'.$user['name'].'" data-role="'.$user['role'].'" class="span-btn"><i class="fas fa-edit table-btn"></i></span>';
            $table    .= '<span id="deleteRowBtn" onclick="deleteRow(this)" data-id="'.$user['id'].'" class="span-btn"><i class="fas fa-trash table-btn"></i></span>';
            $table    .= '</div>';
            $table    .= '</td>';
            $table    .= '</tr>';
        }
        $table    .= '</tbody>';
        $table    .= '</table>';

        return response()->json(
            [
                "status" => "success",
                "msg" => "Get users successful",
                "data" => $table
            ]);        
    }
}
