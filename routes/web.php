<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/dashboard', 'DashboardController@showDashboard')->name('dashboard');
// dashboard

// user 
Route::prefix("/user")->group(function () {
    Route::group(
        ["middleware" => ["admin"]],
        function () {
            Route::get('/', 'UserController@index')->name('user');
            Route::post('/Editprofile', 'UserController@editprofile')->name('Editprofile');
            Route::post('/registerUser', 'UserController@register')->name('registerUser');
            Route::POST('/updateUser', 'UserController@update')->name('updateUser');
            
            Route::get('/viewAllUser', 'UserController@viewAll')->name('viewAllUser');
            Route::get('/deleteUser', 'UserController@delete')->name('deleteUser');
        }
    );
    Route::post('/loginUser', 'UserController@login')->name('loginUser');
    Route::get('/profile', 'UserController@profile')->name('profile');
    
});

//order
Route::prefix("/order")->group(function () {
    Route::get('/', 'OrderController@index')->name('order');
    Route::get('/update/{id}', 'OrderController@updateForm')->name('updateOrderForm');
    Route::get('/viewAll', 'OrderController@viewAll')->name('viewAllOrder');
    Route::get('/addOrder', 'OrderController@addOrder')->name('addOrder');
    Route::post('/orderForms', 'OrderController@orderData')->name('orderForms');
});

//customer
Route::post('/getCustomerByPhone', 'CustomerController@getCustomerByPhone')->name('getCustomerByPhone');




Route::get('/home', 'HomeController@index')->name('home');
