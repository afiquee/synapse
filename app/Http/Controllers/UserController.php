<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Session;

class UserController extends Controller
{
    public function index() {
        return view('user.user');
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
        //
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
        $table    .= '</thead>';
        $table    .= '</tr>';

        $table    .= '<tbody>';
        foreach($users as $user){
            $table    .= '<tr>';
            $table    .= "<td>{$user['id']}</td>";
            $table    .= "<td>{$user['email']}</td>";
            $table    .= "<td>{$user['name']}</td>";
            $table    .= "<td>{$user['role']}</td>";
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
