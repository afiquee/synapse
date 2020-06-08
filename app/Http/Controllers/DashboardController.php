<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function showDashboard() {

        if(Auth::user()->role == 'Admin') {
            return view('dashboard.admin');
        }
        if(Auth::user()->role == 'Production') {
            return view('dashboard.production');
        }
        if(Auth::user()->role == 'Sales') {
            return view('dashboard.sales');
        }

    }
}
