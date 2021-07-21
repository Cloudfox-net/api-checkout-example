<?php

use Illuminate\Support\Facades\Route;

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
    return view('master');
});

Route::post('/payment','\App\Http\Controllers\IndexController@payment');
Route::post('/installments','\App\Http\Controllers\IndexController@installments');
Route::post('/postback','\App\Http\Controllers\IndexController@postback');

