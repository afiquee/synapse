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

// user 
Route::get('/user', 'UserController@index')->name('user');
Route::POST('/registerUser', 'UserController@register')->name('registerUser');
Route::post('/loginUser', 'UserController@login')->name('loginUser');
Route::get('/viewAll', 'UserController@viewAll')->name('viewAll');


//order
Route::get('/order', 'OrderController@index')->name('order');
Route::get('/addOrder', 'OrderController@addOrder')->name('addOrder');

//customer
Route::post('/getCustomerByPhone', 'CustomerController@getCustomerByPhone')->name('getCustomerByPhone');




Route::get('/home', 'HomeController@index')->name('home');

