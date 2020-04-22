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
    return view('welcome');
});


Route::get('/admin','AdminController@index');

Route::get('/register','AuthController@getRegister')->name('register')->middleware('guest');
Route::post('/register','AuthController@postRegister')->middleware('guest');
Route::get('/login','AuthController@getLogin')->name('login')->middleware('guest');
Route::post('/login','AuthController@postLogin')->middleware('guest');

Route::get('/home','AuthController@dashboard')->name('home')->middleware('auth');

Route::get('/logout','AuthController@logout')->name('logout')->middleware('auth');

Route::get('/report','ReportController@index')->name('report')->middleware('auth');

// Route::get('/login','LoginController@index');
